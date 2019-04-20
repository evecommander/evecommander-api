<?php

namespace App\Contracts;

use App\MembershipLevel;
use Illuminate\Support\Collection;

/**
 * Interface HasMembersContract.
 *
 * @property Collection members
 * @property MembershipLevel defaultMembershipLevel
 * @property Collection membershipLevels
 */
interface HasMembersContract
{
    /**
     * Get any memberships that belong to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function members();

    /**
     * Get the membership level that is set as the default for joining this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function defaultMembershipLevel();

    /**
     * Get any membership levels that belong to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function membershipLevels();
}
