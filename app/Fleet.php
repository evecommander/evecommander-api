<?php

namespace App;

use App\Traits\BubblesNotifications;
use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

/**
 * Class Fleet.
 *
 * @property string id
 * @property string fleet_type_id
 * @property string organization_id
 * @property string organization_type
 * @property string title
 * @property string description
 * @property Carbon start_time
 * @property Carbon end_time
 * @property string created_by
 * @property string last_updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relations
 * @property \Illuminate\Database\Eloquent\Collection notifications
 * @property \Illuminate\Database\Eloquent\Collection readNotifications
 * @property \Illuminate\Database\Eloquent\Collection unreadNotifications
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property \Illuminate\Database\Eloquent\Collection fleetType
 * @property \Illuminate\Database\Eloquent\Collection organization
 * @property \Illuminate\Database\Eloquent\Collection createdBy
 * @property \Illuminate\Database\Eloquent\Collection lastUpdatedBy
 * @property \Illuminate\Database\Eloquent\Collection rsvps
 */
class Fleet extends Model
{
    use UuidTrait, Notifiable, BubblesNotifications, HasComments;

    protected $dates = [
        'start_time',
        'end_time',
        'created_at',
        'updated_at',
    ];

    protected function getBubbleToModels(Notification $notification)
    {
        $rsvps = $this->rsvps()->where('response', '>=', 0)->with('character')->get();

        return $rsvps->map(function (Rsvp $rsvp) {
            return $rsvp->character;
        });
    }

    /**
     * Get relation between this fleet and the fleet type it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fleetType()
    {
        return $this->belongsTo(FleetType::class);
    }

    /**
     * Get relation between this fleet and the organization it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this fleet and the character that created it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get relation between this fleet and the character that last updated it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get relation between this fleet and any RSVPs that are attributed to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }
}
