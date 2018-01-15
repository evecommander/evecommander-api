<?php

namespace App\Traits;

use App\Membership;
use App\MembershipLevel;

/**
 * Trait HasMembers
 * @package App\Traits
 *
 * @method morphMany(string $related, string $name)
 * @method belongsTo(string $related, string $foreignKey)
 */
trait HasMembers
{
    public function members()
    {
        return $this->morphMany(Membership::class, 'owner');
    }

    public function defaultMembershipLevel()
    {
        return $this->belongsTo(MembershipLevel::class, 'default_membership_level');
    }

    public function membershipLevels()
    {
        return $this->morphMany(MembershipLevel::class, 'owner');
    }
}