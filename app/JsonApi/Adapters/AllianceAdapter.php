<?php

namespace App\JsonApi\Adapters;

use App\Alliance;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class AllianceAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'corporations',
        'coalition',
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
        'coalition',
        'replacementClaims',
        'invoices',
        'receivedInvoices',
        'notifications',
        'corporations',
        'roles',
        'subscriptions',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Alliance(), $paging);
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

    public function memberships()
    {
        return $this->hasMany();
    }

    public function coalition()
    {
        return $this->queriesOne(function (Alliance $alliance) {
            return $alliance->coalition();
        });
    }

    public function corporations()
    {
        return $this->queriesMany(function (Alliance $alliance) {
            return $alliance->corporations();
        });
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

    public function roles()
    {
        return $this->hasMany();
    }

    public function subscriptions()
    {
        return $this->hasMany();
    }
}
