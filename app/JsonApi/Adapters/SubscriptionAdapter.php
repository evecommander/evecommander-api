<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class SubscriptionAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [
        'notification-type' => 'notification'
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\Subscription(), $paging);
    }

    public function character()
    {
        return $this->belongsTo();
    }

    public function organization()
    {
        return $this->belongsTo();
    }
}
