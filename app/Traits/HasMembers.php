<?php

namespace App\Traits;

use App\Membership;
use App\MembershipLevel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait HasMembers
 *
 * @method morphMany(string $related, string $name)
 * @method belongsTo(string $related, string $foreignKey)
 */
trait HasMembers
{
    /**
     * Get any memberships that belong to the model
     *
     * @return MorphMany
     */
    public function members()
    {
        return $this->morphMany(Membership::class, 'owner');
    }

    /**
     * Get the membership level that is set as the default for joining this model
     *
     * @return BelongsTo
     */
    public function defaultMembershipLevel()
    {
        return $this->belongsTo(MembershipLevel::class, 'default_membership_level');
    }

    /**
     * Get any membership levels that belong to this model
     *
     * @return MorphMany
     */
    public function membershipLevels()
    {
        return $this->morphMany(MembershipLevel::class, 'owner');
    }
}