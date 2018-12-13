<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Wing
 *
 * @property string id
 * @property integer api_id
 * @property string fleet_id
 * @property string name
 *
 * Relations
 * @property Fleet fleet
 * @property \Illuminate\Database\Eloquent\Collection squads
 * @property \Illuminate\Database\Eloquent\Collection fleetMembers
 * @property \Illuminate\Database\Eloquent\Collection audits
 */
class Wing extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, UuidTrait, SoftDeletes;

    /**
     * Get relation between this wing and the fleet it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    /**
     * Get relation between this wing and any squads that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function squads()
    {
        return $this->hasMany(Squad::class);
    }

    /**
     * Get relation between this wing and any fleet members that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fleetMembers()
    {
        return $this->hasMany(FleetMember::class);
    }
}
