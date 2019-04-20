<?php

namespace App;

use App\Abstracts\Organization;
use App\Contracts\HasCommentsContract;
use App\Contracts\HasNotificationsContract;
use App\Contracts\HasRolesContract;
use App\Contracts\HasSRPContract;
use App\Contracts\IsMemberContract;
use App\Contracts\ReceivesInvoicesContract;
use App\Traits\HasSRP;
use App\Traits\IsMember;
use App\Traits\ReceivesInvoices;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Builder;
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
class Character extends Model implements
    IsMemberContract,
    ReceivesInvoicesContract,
    HasNotificationsContract,
    HasCommentsContract,
    HasRolesContract,
    HasSRPContract
{
    use UuidTrait, IsMember, ReceivesInvoices, Notifiable, HasSRP;

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
        return $this->memberships()
            ->where('organization_type', Corporation::class)
            ->with('organization');
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
     * Returns whether the character has a given permission for a given organization.
     *
     * @param string       $slug
     * @param Organization $organization
     *
     * @return bool
     */
    public function hasPermission(string $slug, Organization $organization)
    {
        return $this->roles()
            ->where('organization_id', '=', $organization->id)
            ->where('organization_type', '=', get_class($organization))
            ->whereHas('permissions', function (Builder $query) use ($slug, $organization) {
                $query->where('slug', '=', $slug);
            })->exists();
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

    /**
     * Get relation between this model and any replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replacementClaims()
    {
        return $this->hasMany(ReplacementClaim::class);
    }

    /**
     * Get relation between this model and any pending replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pendingReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_PENDING);
    }

    /**
     * Get relation between this model and any closed replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function closedReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_CLOSED);
    }

    /**
     * Get relation between this model and any accepted replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acceptedReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_ACCEPTED);
    }

    /**
     * Get relation between this model and any contested replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contestedReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_CONTESTED);
    }

    /**
     * Get relation between this model and any payed replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payedReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_PAYED);
    }

    /**
     * Get relation between this character and any fleets it has been a part of.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function fleets()
    {
        return $this->hasManyThrough(Fleet::class, FleetMember::class);
    }

    /**
     * Get relation between this character and any fleet members that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fleetMemberships()
    {
        return $this->hasMany(FleetMember::class);
    }
}
