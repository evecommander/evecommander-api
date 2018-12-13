<?php

namespace App\JsonApi\Adapters;

use App\Corporation;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class CorporationAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'alliance',
        'characters',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Corporation(), $paging);
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

    public function alliance()
    {
        return $this->queriesOne(function (Corporation $corporation) {
            return $corporation->alliance();
        });
    }

    public function characters()
    {
        return $this->queriesMany(function (Corporation $corporation) {
            return $corporation->characters();
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
