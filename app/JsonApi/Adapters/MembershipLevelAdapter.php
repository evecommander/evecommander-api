<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class MembershipLevelAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'created-by',
        'last-updated-by'
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\MembershipLevel(), $paging);
    }

    public function memberships()
    {
        return $this->hasMany();
    }

    public function organization()
    {
        return $this->belongsTo();
    }

    public function createdBy()
    {
        return $this->belongsTo();
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo();
    }

    public function roles()
    {
        return $this->hasMany();
    }
}
