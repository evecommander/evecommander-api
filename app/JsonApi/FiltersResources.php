<?php

namespace App\JsonApi;

use CloudCreativity\LaravelJsonApi\Document\Error;
use CloudCreativity\LaravelJsonApi\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Neomerx\JsonApi\Contracts\Encoder\Parameters\EncodingParametersInterface;

/**
 * Trait FiltersResources.
 *
 * @property Model model
 */
trait FiltersResources
{
    protected function with(Builder $query, EncodingParametersInterface $parameters)
    {
        $query->with($this->getRelationshipPaths((array) $parameters->getIncludePaths()))
            ->with($this->makeRelationFilters($parameters));
    }

    /**
     * @param Builder    $query
     * @param Collection $filters
     */
    protected function filter($query, Collection $filters)
    {
        foreach ($filters as $name => $value) {
            $this->doFilter($query, $this->model, $name, $value);
        }
    }

    private function doFilter(Builder $query, $model, $filter, $value)
    {
        if (is_numeric($filter)) {
            foreach ($value as $key => $val) {
                $this->doFilter($query, $model, $key, $val);
            }
        } elseif (strtolower($filter) === 'or') {
            foreach ($value as $key => $val) {
                $query->orWhere(function ($query) use ($model, $key, $val) {
                    $this->doFilter($query, $model, $key, $val);
                });
            }
        } elseif (strtolower($filter) === 'and') {
            foreach ($value as $key => $val) {
                $query->where(function ($query) use ($model, $key, $val) {
                    $this->doFilter($query, $model, $key, $val);
                });
            }
        } elseif (strpos($filter, '.')) {
            $filterTableName = reset(explode('.', $filter));
            $filterName = null;
            $needle = '.';
            $pos = strpos($filter, $needle);

            if ($pos !== false) {
                $filterName = substr($filter, $pos + 1);
            }

            $incModel = $model->{$filterTableName}()->getRelated();
            $query->whereHas($filterTableName, function ($query) use ($incModel, $filterName, $value) {
                $this->doFilter($query, $incModel, $filterName, $value);
            });
        } else {
            $params = explode('__', $filter);
            $operator = null;
            $name = null;

            if (count($params) == 1) {
                $name = $params[0];
            } elseif (count($params) == 2) {
                $name = $params[0];
                $operator = $params[1];
            } else {
                throw new ValidationException(Error::create([
                    'status' => 422,
                    'title'  => 'Unknown value passed for filter',
                    'detail' => "Unknown value {{$name}}",
                    'source' => ['parameter' => "filter[{$name}]=$value"],
                ]));
            }

            $name = $this->modelKeyForField($name, $model);

            if (!Schema::connection($this->model->getConnectionName())->hasColumn($this->model->getTable(), $name)) {
                throw new ValidationException(Error::create([
                    'status' => 422,
                    'title'  => "Unknown key passed for filter: {$name}",
                ]));
            }

            $this->applyFilter($query, $operator, $name, $value);
        }
    }

    private function applyFilter(Builder $filterQuery, $operator, $name, $value)
    {
        switch ($operator) {
            case null:
            case 'is':
                if (in_array(strtolower($value), ['true', 'false', '0', '1'])) {
                    $filterQuery->where($name, filter_var($value, FILTER_VALIDATE_BOOLEAN));
                } else {
                    $filterQuery->where($name, $value);
                }
                break;
            case 'isnot':
            case 'not':
                $filterQuery->where($name, '!=', $value);
                break;

            case 'gte':
                $filterQuery->where($name, '>=', $value);
                break;
            case 'lte':
                $filterQuery->where($name, '<=', $value);
                break;
            case 'gt':
                $filterQuery->where($name, '>', $value);
                break;
            case 'lt':
                $filterQuery->where($name, '<', $value);
                break;
            case 'isnull':
                $filterQuery->whereNull($name);
                break;
            case 'null':
                if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
                    $filterQuery->whereNull($name);
                } else {
                    $filterQuery->whereNotNull($name);
                }
                break;
            case 'notnull':
                $filterQuery->whereNotNull($name);
                break;
            case 'excludes':
            case 'notin':
                $items = is_array($value) ? $value : explode(',', $value);
                $filterQuery->whereNotIn($name, $items);
                break;
            case 'in':
            case 'includes':
                $items = is_array($value) ? $value : explode(',', $value);
                $filterQuery->whereIn($name, $items);
                break;
            case 'contains':
            case 'like':
                $filterQuery->where($name, 'like', "%{$value}%");
                break;
            case 'starts':
                $filterQuery->where($name, 'like', "{$value}%");
                break;
            case 'ends':
                $filterQuery->where($name, 'like', "%{$value}");
                break;
            case 'icontains':
                $filterQuery->where($name, 'COLLATE UTF8_GENERAL_CI like', "%{$value}%");
                break;
            case 'istarts':
                $filterQuery->where($name, 'COLLATE UTF8_GENERAL_CI like', "{$value}%");
                break;
            case 'iends':
                $filterQuery->where($name, 'COLLATE UTF8_GENERAL_CI like', "%{$value}");
                break;
        }
    }

    /**
     * If Relationship filters are enabled, add them to the model involved in this request.
     *
     * @param EncodingParametersInterface $parameters
     *
     * @return array
     */
    public function makeRelationFilters(EncodingParametersInterface $parameters)
    {
        $unrecognized = $parameters->getUnrecognizedParameters();

        if (!isset($unrecognized['filterRelations']) || !filter_var($unrecognized['filterRelations'], FILTER_VALIDATE_BOOLEAN)) {
            return [];
        }

        $filters = $parameters->getFilteringParameters() ?? [];
        $relationFilters = [];

        foreach ($filters as $filter => $val) {
            if (strpos($filter, '.')) {
                $filterNameArr = explode('.', $filter);
                $columnName = array_pop($filterNameArr);
                $relationFilter = implode('.', $filterNameArr);
                $relationFilters = array_merge_recursive($relationFilters, [$relationFilter => [$columnName => $val]]);
            }
        }

        $relations = [];
        foreach ($relationFilters as $relation => $constraints) {
            $relations[$relation] = function ($query) use ($constraints) {
                $this->addRelationFilters($query, $constraints);
            };
        }

        return $relations;
    }

    /**
     * Add filters to the Relation.
     *
     * @param Relation $query
     * @param array    $filters
     */
    protected function addRelationFilters(Relation $query, array $filters)
    {
        foreach ($filters as $filter => $val) {
            $params = explode('__', $filter);
            $op = null;
            $name = null;

            if (count($params) == 1) {
                $name = $params[0];
            } elseif (count($params) == 2) {
                $name = $params[0];
                $op = $params[1];
            } else {
                throw new ValidationException(Error::create([
                    'status' => 422,
                    'title'  => 'Unknown value passed for filter',
                    'detail' => "Unknown value {{$name}}",
                    'source' => ['parameter' => "filter[{$name}]=$val"], ]));
            }

            $name = $this->modelKeyForField($name, $this->model);

            if (!Schema::connection($this->model->getConnectionName())->hasColumn($this->model->getTable(), $name)) {
                throw new ValidationException(Error::create([
                    'status' => 422,
                    'title'  => "Unknown key passed for filter: {$name}",
                ]));
            }

            $this->applyRelationFilter($query, $op, $name, $val, $query->getRelated());
        }
    }

    /**
     * Adds the given filter to the query.
     *
     * @param Builder $filterQuery
     * @param $operator
     * @param $name
     * @param $value
     * @param Model $model
     */
    public function applyRelationFilter($filterQuery, $operator, $name, $value, Model $model)
    {
        /* @var $filterQuery Builder|Relation */
        if ($model->hasSetMutator($name)) {
            $mutated = $model->{'set'.Str::studly($name).'Attribute'}($value);
            $value = !is_null($mutated) ? $mutated : $value;
        }

        $name = implode('.', [$model->getTable(), $name]);

        $this->applyFilter($filterQuery, $operator, $name, $value);
    }
}
