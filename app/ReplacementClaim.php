<?php

namespace App;

use App\Notifications\ReplacementClaim\Approved;
use App\Notifications\ReplacementClaim\Submitted;
use App\Traits\BubblesNotifications;
use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

/**
 * Class ReplacementClaim.
 *
 * @property string id
 * @property string character_id
 * @property string organization_id
 * @property string organization_type
 * @property string fitting_id
 * @property int killmail_id
 * @property string killmail_hash
 * @property float total
 * @property string status
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property \Illuminate\Database\Eloquent\Collection character
 * @property \Illuminate\Database\Eloquent\Collection organization
 * @property \Illuminate\Database\Eloquent\Collection fitting
 */
class ReplacementClaim extends Model
{
    use HasComments, Notifiable, UuidTrait, BubblesNotifications;

    protected function getBubbleToModels(Notification $notification)
    {
        // when a claim is submitted, we only want to alert the organization
        if ($notification instanceof Submitted) {
            return $this->organization;
        }

        // otherwise, we want to notify the character
        return $this->character;
    }

    /**
     * Get Character that this ReplacementClaim belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get Organization that this ReplacementClaim belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this replacement claim and the fitting it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fitting()
    {
        return $this->belongsTo(Fitting::class);
    }
}
