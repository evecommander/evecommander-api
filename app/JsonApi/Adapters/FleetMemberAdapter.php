<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class FleetMemberAdapter extends AbstractAdapter
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
        parent::__construct(new \App\FleetMember(), $paging);
    }

    public function fleet()
    {
        return $this->belongsTo();
    }

    public function wing()
    {
        return $this->belongsTo();
    }

    public function squad()
    {
        return $this->belongsTo();
    }

    public function character()
    {
        return $this->belongsTo();
    }

    public function history()
    {
        return $this->hasMany('audits');
    }
}
