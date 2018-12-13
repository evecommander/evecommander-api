<?php

namespace App\JsonApi\Adapters;

use App\Fleet;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class FleetAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'created-by',
        'last-updated-by',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Fleet(), $paging);
    }

    public function fleetType()
    {
        return $this->belongsTo();
    }

    public function organization()
    {
        return $this->belongsTo();
    }

    public function createdBy()
    {
        return $this->belongsTo();
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo();
    }

    public function comments()
    {
        return $this->hasMany();
    }

    public function notifications()
    {
        return $this->hasMany();
    }

    public function rsvps()
    {
        return $this->hasMany();
    }

    public function trackerCharacter()
    {
        return $this->belongsTo();
    }

    public function members()
    {
        return $this->hasMany();
    }

    public function wings()
    {
        return $this->hasMany();
    }

    public function squads()
    {
        return $this->hasMany();
    }
}
