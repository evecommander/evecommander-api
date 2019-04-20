<?php

namespace App\JsonApi\Adapters;

use App\Doctrine;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Facades\Auth;

class DoctrineAdapter extends AbstractAdapter
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
        parent::__construct(new Doctrine(), $paging);
    }

    public function organization()
    {
        return $this->belongsTo();
    }

    public function fittings()
    {
        return $this->hasMany();
    }

    public function createdBy()
    {
        return $this->belongsTo();
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo();
    }

    protected function creating(Doctrine $doctrine)
    {
        $doctrine->createdBy()->associate(Auth::user());
    }

    protected function updating(Doctrine $doctrine)
    {
        $doctrine->lastUpdatedBy()->associate(Auth::user());
    }
}
