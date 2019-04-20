<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class BillingConditionGroupAdapter extends AbstractAdapter
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
        parent::__construct(new \App\BillingConditionGroup(), $paging);
    }

    public function organization()
    {
        return $this->belongsTo();
    }

    public function membershipFees()
    {
        return $this->hasMany();
    }

    public function billingConditions()
    {
        return $this->hasMany();
    }

    public function childGroups()
    {
        return $this->hasMany();
    }

    public function parentGroup()
    {
        return $this->belongsTo();
    }
}
