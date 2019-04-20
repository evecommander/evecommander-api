<?php

namespace App\JsonApi\Adapters;

use App\Handbook;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Facades\Auth;

class HandbookAdapter extends AbstractAdapter
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
        'deleted-at',
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
        parent::__construct(new Handbook(), $paging);
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

    protected function creating(Handbook $handbook)
    {
        $handbook->createdBy()->associate(Auth::user());
    }

    protected function updating(Handbook $handbook)
    {
        $handbook->lastUpdatedBy()->associate(Auth::user());
    }
}
