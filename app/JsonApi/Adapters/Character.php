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

    protected function user()
    {
        return $this->belongsTo();
    }

    protected function token()
    {
        return$this->hasOne();
    }

    protected function comments()
    {
        return $this->hasMany();
    }

    protected function memberships()
    {
        return $this->hasMany();
    }

    protected function invoices()
    {
        return $this->hasMany();
    }

    protected function fulfilledInvoices()
    {
        return $this->hasMany();
    }

    protected function overdueInvoices()
    {
        return $this->hasMany();
    }

    protected function pendingInvoices()
    {
        return $this->hasMany();
    }

    protected function defaultInvoices()
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
