<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use App\Membership;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class MembershipAdapter extends AbstractAdapter
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
        'last-updated-by',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Membership(), $paging);
    }

    public function membershipLevel()
    {
        return $this->belongsTo();
    }

    public function organization()
    {
        return $this->belongsTo();
    }

    public function member()
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

    public function notifications()
    {
        return $this->hasMany();
    }
}
