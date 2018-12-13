<?php

namespace App\JsonApi\Adapters;

use App\Character;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class CharacterAdapter extends AbstractAdapter
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
        parent::__construct(new Character(), $paging);
    }

    public function user()
    {
        return $this->belongsTo();
    }

    public function token()
    {
        return $this->hasOne();
    }

    public function comments()
    {
        return $this->hasMany();
    }

    public function memberships()
    {
        return $this->hasMany();
    }

    public function invoices()
    {
        return $this->hasMany();
    }

    public function notifications()
    {
        return $this->hasMany();
    }

    public function corporation()
    {
        return $this->queriesOne(function (Character $character) {
            return $character->corporation();
        });
    }

    public function roles()
    {
        return $this->hasMany();
    }

    public function subscriptions()
    {
        return $this->hasMany();
    }

    public function rsvps()
    {
        return $this->hasMany();
    }
}
