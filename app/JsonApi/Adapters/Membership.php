<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class Membership extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'createdBy',
    ];

    /**
     * Resource relationship fields that can be filled.
     *
     * @var array
     */
    protected $relationships = [
        'membershipLevel',
        'organization',
        'member',
        'createdBy',
        'lastUpdatedBy',
        'notifications',
        'readNotifications',
        'unreadNotifications',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\Membership(), $paging);
    }

    public function membershipLevel()
    {
        return $this->belongsTo();
    }

    public function organization()
    {
        return $this->hasOne();
    }

    public function member()
    {
        return $this->hasOne();
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

    public function readNotifications()
    {
        return $this->hasMany();
    }

    public function unreadNotifications()
    {
        return $this->hasMany();
    }
}
