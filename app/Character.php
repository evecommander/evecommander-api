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
 * @property int eve_id
 * @property string name
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany notifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany readNotifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany unreadNotifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany invoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany fulfilledInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany overdueInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany pendingInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany defaultInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany memberships
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo user
 * @property \Illuminate\Database\Eloquent\Relations\HasOne token
 * @property \Illuminate\Database\Eloquent\Relations\HasMany comments
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany corporation
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
        return $this->memberships()->where('owner_type', Corporation::class)->with('owner');
    }
}
