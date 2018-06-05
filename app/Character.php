<?php

namespace App;

use App\Traits\BubblesNotifications;
use App\Traits\IsMember;
use App\Traits\ReceivesInvoices;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class Character.
 *
 * @property string id
 * @property int user_id
 * @property int api_id
 * @property string name
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection notifications
 * @property \Illuminate\Database\Eloquent\Collection readNotifications
 * @property \Illuminate\Database\Eloquent\Collection unreadNotifications
 * @property \Illuminate\Database\Eloquent\Collection invoices
 * @property \Illuminate\Database\Eloquent\Collection fulfilledInvoices
 * @property \Illuminate\Database\Eloquent\Collection overdueInvoices
 * @property \Illuminate\Database\Eloquent\Collection pendingInvoices
 * @property \Illuminate\Database\Eloquent\Collection defaultInvoices
 * @property \Illuminate\Database\Eloquent\Collection memberships
 * @property User user
 * @property OAuth2Token token
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property Corporation corporation
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection rsvps
 */
class Character extends Model
{
    use UuidTrait, IsMember, ReceivesInvoices, Notifiable, BubblesNotifications;

    public $bubbleToRelation = 'user';

    /**
     * Get the user that this character belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the OAuth2Token that is character owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function token()
    {
        return $this->hasOne(OAuth2Token::class);
    }

    /**
     * Get all comments belonging to the character.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the corporation that the character is a member of.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function corporation()
    {
        return $this->memberships()->where('organization_type', Corporation::class)->with('organization');
    }

    /**
     * Get relation between this character and any roles they are assigned.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Get relation between this character and any RSVPs that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }
}
