<?php

namespace App\JsonApi\Adapters;

use App\Invoice;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class InvoiceAdapter extends AbstractAdapter
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
        'issuer',
        'recipient',
        'items',
        'payments',
        'comments',
        'notifications',
        'lastUpdatedBy',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Invoice(), $paging);
    }

    public function issuer()
    {
        return $this->belongsTo();
    }

    public function recipient()
    {
        return $this->belongsTo();
    }

    public function items()
    {
        return $this->hasMany();
    }

    public function payments()
    {
        return $this->hasMany();
    }

    public function comments()
    {
        return $this->hasMany();
    }

    public function notifications()
    {
        return $this->hasMany();
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo();
    }
}
