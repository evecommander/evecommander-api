<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class Membership
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
 * @property string member_id
 * @property string member_type
 * @property string membership_level_id
 * @property string notes
 * @property string created_by
 * @property string last_updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany notifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany readNotifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany unreadNotifications
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo membershipLevel
 * @property \Illuminate\Database\Eloquent\Relations\MorphTo organization
 * @property \Illuminate\Database\Eloquent\Relations\MorphTo member
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo createdBy
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo lastUpdatedBy
 */
class Membership extends Model
{
    use Notifiable;

    /**
     * Get the membership level that this membership belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function membershipLevel()
    {
        return $this->belongsTo(MembershipLevel::class);
    }

    /**
     * Get the organization model for this membership
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get the member model for this membership
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function member()
    {
        return $this->morphTo();
    }

    /**
     * Get the character that created this membership
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Character::class, 'created_by');
    }

    /**
     * Get the character that last edited this membership
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class, 'last_updated_by');
    }
}
