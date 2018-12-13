<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class WingAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'history',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\Wing(), $paging);
    }

    public function fleet()
    {
        return $this->belongsTo();
    }

    public function squads()
    {
        return $this->hasMany();
    }

    public function fleetMembers()
    {
        return $this->hasMany();
    }

    public function history()
    {
        return $this->hasMany('audits');
    }
}
