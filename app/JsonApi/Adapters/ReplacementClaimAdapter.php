<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use App\ReplacementClaim;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Facades\Auth;

class ReplacementClaimAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'last-updated-by',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new ReplacementClaim(), $paging);
    }

    public function character()
    {
        return $this->belongsTo();
    }

    public function organization()
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

    public function lastUpdatedBy()
    {
        return $this->belongsTo();
    }

    protected function updating(ReplacementClaim $replacementClaim)
    {
        $replacementClaim->lastUpdatedBy()->associate(Auth::user());
    }

    protected function creating(ReplacementClaim $replacementClaim)
    {
    }
}
