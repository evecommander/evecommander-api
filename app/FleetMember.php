<?php

namespace App;

use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class FleetMember
 *
 * @property string id
 * @property string fleet_id
 * @property integer wing_id
 * @property integer squad_id
 * @property integer character_api_id
 * @property string character_id
 * @property Carbon join_time
 * @property string role
 * @property integer ship_type_id
 * @property integer solar_system_id
 * @property integer station_id
 * @property boolean takes_fleet_warp
 *
 * Relations
 * @property Fleet fleet
 * @property Wing wing
 * @property Squad squad
 * @property Character character
 * @property \Illuminate\Database\Eloquent\Collection audits
 */
class FleetMember extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, UuidTrait, SoftDeletes;

    const ROLE_FLEET_COMMANDER = 'fleet_commander';
    const ROLE_WING_COMMANDER = 'wing_commander';
    const ROLE_SQUAD_COMMANDER = 'squad_commander';
    const ROLE_SQUAD_MEMBER = 'squad_member';

    protected $dates = [
        'join_time'
    ];

    /**
     * Get relation between this fleet member and the fleet it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    /**
     * Get relation between this fleet member and the wing it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wing()
    {
        return $this->belongsTo(Wing::class);
    }

    /**
     * Get relation between this fleet member and the squad it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function squad()
    {
        return $this->belongsTo(Squad::class);
    }

    /**
     * Get relation between this fleet member and the character it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
