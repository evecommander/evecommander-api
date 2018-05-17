<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class Character extends AbstractAdapter
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
        'user',
        'token',
        'comments',
        'memberships',
        'invoices',
        'fulfilledInvoices',
        'overdueInvoices',
        'pendingInvoices',
        'defaultInvoices',
        'notifications',
        'readNotifications',
        'unreadNotifications',
        'corporation',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\Character(), $paging);
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

    public function corporation()
    {
        return $this->hasMany();
    }
}
