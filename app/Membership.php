<?php

namespace App;

use App\Abstracts\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
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
 * @property MembershipLevel membershipLevel
 * @property Organization organization
 * @property mixed member
 * @property Character createdBy
 * @property Character lastUpdatedBy
 */
class Membership extends Model
{
    use Notifiable, SoftDeletes;

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
