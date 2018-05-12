<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class ReplacementClaim extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'readNotifications',
        'unreadNotifications',
    ];

    /**
     * Resource relationship fields that can be filled.
     *
     * @var array
     */
    protected $relationships = [
        'character',
        'organization',
        'comments',
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
        parent::__construct(new \App\ReplacementClaim(), $paging);
    }

    public function character()
    {
        return $this->belongsTo();
    }

    public function organization()
    {
        return $this->hasOne();
    }

    public function comments()
    {
        return $this->hasMany();
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
