<?php

namespace App;

use App\Notifications\Membership\CommentPosted;
use App\Traits\BubblesNotifications;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

/**
 * Class Membership.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
 * @property string member_id
 * @property string member_type
 * @property string membership_level_id
 * @property string notes
 * @property string created_by
 * @property string last_updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection notifications
 * @property \Illuminate\Database\Eloquent\Collection readNotifications
 * @property \Illuminate\Database\Eloquent\Collection unreadNotifications
 * @property \Illuminate\Database\Eloquent\Collection membershipLevel
 * @property \Illuminate\Database\Eloquent\Collection organization
 * @property \Illuminate\Database\Eloquent\Collection member
 * @property \Illuminate\Database\Eloquent\Collection createdBy
 * @property \Illuminate\Database\Eloquent\Collection lastUpdatedBy
 */
class Membership extends Model
{
    use Notifiable, BubblesNotifications, SoftDeletes;

    protected function getBubbleToModels(Notification $notification)
    {
        // if a comment was posted, forward to both organization and member
        if ($notification instanceof CommentPosted) {
            return $this->member->merge($this->organization);
        }

        // else, only send to member
        return $this->member;
    }

    /**
     * Get the membership level that this membership belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function membershipLevel()
    {
        return $this->belongsTo(MembershipLevel::class);
    }

    /**
     * Get the organization model for this membership.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get the member model for this membership.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function member()
    {
        return $this->morphTo();
    }

    /**
     * Get the character that created this membership.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Character::class, 'created_by');
    }

    /**
     * Get the character that last edited this membership.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class, 'last_updated_by');
    }
}
