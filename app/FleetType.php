<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class FleetType
 *
 * @property string id
 * @property string name
 * @property string description
 * @property Carbon created_at
 * @property Carbon updated_at
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
}
