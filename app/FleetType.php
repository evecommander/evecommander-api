<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class FleetType.
 *
 * @property string id
 * @property string name
 * @property string description
 * @property string organization_id
 * @property string organization_type
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection fleets
 * @property Organization organization
 */
class FleetType extends Model
{
    use UuidTrait;

    /**
     * Get relation between this fleet type and any fleets that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fleets()
    {
        return $this->hasMany(Fleet::class);
    }

    /**
     * Get relation between this fleet type and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }
}
