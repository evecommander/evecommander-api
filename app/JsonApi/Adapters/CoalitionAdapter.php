<?php

namespace App\JsonApi\Adapters;

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
        'fulfilledInvoices',
        'overdueInvoices',
        'pendingInvoices',
        'defaultInvoices',
        'fulfilledReceivedInvoices',
        'overdueReceivedInvoices',
        'pendingReceivedInvoices',
        'defaultReceivedInvoices',
        'readNotifications',
        'unreadNotifications',
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
        'fulfilledInvoices',
        'overdueInvoices',
        'pendingInvoices',
        'defaultInvoices',
        'leader',
        'fulfilledInvoices',
        'overdueInvoices',
        'pendingInvoices',
        'defaultInvoices',
        'receivedInvoices',
        'fulfilledReceivedInvoices',
        'overdueReceivedInvoices',
        'pendingReceivedInvoices',
        'defaultReceivedInvoices',
        'notifications',
        'readNotifications',
        'unreadNotifications',
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
        parent::__construct(new \App\Coalition(), $paging);
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

    public function fulfilledInvoices()
    {
        return $this->hasMany();
    }

    public function overdueInvoices()
    {
        return $this->hasMany();
    }

    public function pendingInvoices()
    {
        return $this->hasMany();
    }

    public function defaultInvoices()
    {
        return $this->hasMany();
    }

    public function receivedInvoices()
    {
        return $this->hasMany();
    }

    public function fulfilledReceivedInvoices()
    {
        return $this->hasMany();
    }

    public function overdueReceivedInvoices()
    {
        return $this->hasMany();
    }

    public function pendingReceivedInvoices()
    {
        return $this->hasMany();
    }

    public function defaultReceivedInvoices()
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
}
