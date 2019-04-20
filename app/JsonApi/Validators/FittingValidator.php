<?php

namespace App\JsonApi\Validators;

use CloudCreativity\LaravelJsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;

class FittingValidator extends AbstractValidators
{
    /**
     * @var string
     */
    protected $resourceType = 'fittings';

    /**
     * The include paths a client is allowed to request.
     *
     * @var string[]|null
     *      the allowed paths, an empty array for none allowed, or null to allow all paths.
     */
    protected $allowedIncludePaths = null;

    /**
     * The sort field names a client is allowed send.
     *
     * @var string[]|null
     *      the allowed fields, an empty array for none allowed, or null to allow all fields.
     */
    protected $allowedSortParameters = [
        'name',
        'created-at'
    ];

    /**
     * Get resource validation rules.
     *
     * @param mixed|null $record
     *      the record being updated, or null if creating a resource.
     * @return array
     */
    protected function rules($record = null): array
    {
        return [
            'name' => 'required|string',
            'description' => 'string',
            'api-id' => 'required|integer',
        ];
    }

    /**
     * Get query parameter validation rules.
     *
     * @return array
     */
    protected function queryRules(): array
    {
        return [
            //
        ];
    }
}
