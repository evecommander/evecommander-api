<?php

namespace App\JsonApi\Adapters;

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
        'fulfilledInvoices',
        'overdueInvoices',
        'pendingInvoices',
        'defaultInvoices',
        'fulfilledIssuedInvoices',
        'overdueIssuedInvoices',
        'pendingIssuedInvoices',
        'defaultIssuedInvoices',
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
        'coalition',
        'claims',
        'invoices',
        'fulfilledInvoices',
        'overdueInvoices',
        'pendingInvoices',
        'defaultInvoices',
        'issuedInvoices',
        'fulfilledIssuedInvoices',
        'overdueIssuedInvoices',
        'pendingIssuedInvoices',
        'defaultIssuedInvoices',
        'notifications',
        'readNotifications',
        'unreadNotifications',
        'corporations',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\Alliance(), $paging);
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
        return $this->hasMany();
    }

    public function corporations()
    {
        return $this->hasMany();
    }

    public function claims()
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

    public function issuedInvoices()
    {
        return $this->hasMany();
    }

    public function fulfilledIssuedInvoices()
    {
        return $this->hasMany();
    }

    public function overdueIssuedInvoices()
    {
        return $this->hasMany();
    }

    public function pendingIssuedInvoices()
    {
        return $this->hasMany();
    }

    public function defaultIssuedInvoices()
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
