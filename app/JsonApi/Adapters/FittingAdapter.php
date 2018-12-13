<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class FittingAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\Fitting(), $paging);
    }

    public function organization()
    {
        return $this->belongsTo();
    }

    public function doctrine()
    {
        return $this->belongsTo();
    }

    public function replacementClaims()
    {
        return $this->hasMany();
    }
}
