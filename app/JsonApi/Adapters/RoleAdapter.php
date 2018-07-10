<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class RoleAdapter extends AbstractAdapter
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
        'organization',
        'permissions',
        'characters',
        'membershipLevels',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\Role(), $paging);
    }

    public function organization()
    {
        return $this->belongsTo();
    }

    public function permissions()
    {
        return $this->hasMany();
    }

    public function characters()
    {
        return $this->hasMany();
    }

    public function membershipLevels()
    {
        return $this->hasMany();
    }
}
