<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use App\MembershipLevel;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Facades\Auth;

class MembershipLevelAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'created-at',
        'updated-at',
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
        parent::__construct(new MembershipLevel(), $paging);
    }

    public function memberships()
    {
        return $this->hasMany();
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

    public function roles()
    {
        return $this->hasMany();
    }

    public function membershipFees()
    {
        return $this->morphMany();
    }

    public function discounts()
    {
        return $this->morphMany();
    }

    protected function creating(MembershipLevel $membershipLevel)
    {
        $membershipLevel->createdBy()->associate(Auth::user());
    }

    protected function updating(MembershipLevel $membershipLevel)
    {
        $membershipLevel->lastUpdatedBy()->associate(Auth::user());
    }
}
