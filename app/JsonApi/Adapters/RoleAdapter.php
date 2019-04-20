<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use App\Role;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Facades\Auth;

class RoleAdapter extends AbstractAdapter
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
        parent::__construct(new Role(), $paging);
    }

    public function organization()
    {
        return $this->belongsTo();
    }

    public function permissions()
    {
        return $this->hasMany();
    }

    public function characters()
    {
        return $this->hasMany();
    }

    public function membershipLevels()
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

    protected function creating(Role $role)
    {
        $role->createdBy()->associate(Auth::user());
    }

    protected function updating(Role $role)
    {
        $role->lastUpdatedBy()->associate(Auth::user());
    }
}
