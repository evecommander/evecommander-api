<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class UserAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Resource relationship fields that can be filled.
     *
     * @var array
     */
    protected $relationships = [
        'characters',
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
        parent::__construct(new \App\User(), $paging);
    }

    protected function characters()
    {
        return $this->hasMany();
    }

    protected function notifications()
    {
        return $this->hasMany();
    }

    protected function readNotifications()
    {
        return $this->hasMany();
    }

    protected function unreadNotifications()
    {
        return $this->hasMany();
    }
}
