<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Squad.
 *
 * @property string id
 * @property int api_id
 * @property string name
 *
 * Relations
 * @property Wing wing
 * @property \Illuminate\Database\Eloquent\Collection fleetMembers
 * @property \Illuminate\Database\Eloquent\Collection audits
 */
class Squad extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, UuidTrait, SoftDeletes;

    /**
     * Get relation between this squad and the wing it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wing()
    {
        return $this->belongsTo(Wing::class);
    }

    /**
     * Get relation between this squad and any fleet members that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fleetMembers()
    {
        return $this->hasMany(FleetMember::class);
    }
}
