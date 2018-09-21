<?php

namespace App;

use App\Abstracts\Organization;
use App\Contracts\HasNotificationsContract;
use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
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
 * @property string status
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
 * @property FleetType fleetType
 * @property Organization organization
 * @property Character createdBy
 * @property Character lastUpdatedBy
 * @property \Illuminate\Database\Eloquent\Collection rsvps
 */
class Fleet extends Model implements HasNotificationsContract
{
    use UuidTrait, Notifiable, HasComments;

    const STATUS_PENDING = 'pending';
    const STATUS_STANDBY = 'standby';
    const STATUS_FORM_UP = 'form-up';
    const STATUS_IN_PROGRESS = 'in-progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const AVAILABLE_STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_STANDBY,
        self::STATUS_FORM_UP,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    protected $dates = [
        'start_time',
        'end_time',
        'created_at',
        'updated_at',
    ];

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
