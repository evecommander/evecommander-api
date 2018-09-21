<?php

namespace App\JsonApi\Adapters;

use App\Coalition;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class CoalitionAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'alliances',
    ];

    /**
     * Resource relationship fields that can be filled.
     *
     * @var array
     */
    protected $relationships = [
        'handbooks',
        'members',
        'defaultMembershipLevel',
        'membershipLevels',
        'memberships',
        'replacementClaims',
        'invoices',
        'leader',
        'receivedInvoices',
        'notifications',
        'roles',
        'subscriptions',
        'alliances',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Coalition(), $paging);
    }

    public function handbooks()
    {
        return $this->hasMany();
    }

    public function members()
    {
        return $this->hasMany();
    }

    public function defaultMembershipLevel()
    {
        return $this->belongsTo();
    }

    public function membershipLevels()
    {
        return $this->hasMany();
    }

    public function replacementClaims()
    {
        return $this->hasMany();
    }

    public function invoices()
    {
        return $this->hasMany();
    }

    public function receivedInvoices()
    {
        return $this->hasMany();
    }

    public function notifications()
    {
        return $this->hasMany();
    }

    public function leader()
    {
        return $this->belongsTo();
    }

    public function roles()
    {
        return $this->hasMany();
    }

    public function subscriptions()
    {
        return $this->hasMany();
    }

    public function alliances()
    {
        return $this->queriesMany(function (Coalition $coalition) {
            return $coalition->alliances();
        });
    }
}
