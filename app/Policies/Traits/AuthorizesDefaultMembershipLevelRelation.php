<?php

namespace App\Policies\Traits;

use App\Abstracts\Organization;
use App\User;

trait AuthorizesDefaultMembershipLevelRelation
{
    /**
     * Determine whether the user can read the default membership level.
     *
     * @param User         $user
     * @param Organization $organization
     *
     * @return bool
     */
    public function readDefaultMembershipLevel(User $user, Organization $organization)
    {
        return $this->readRelationship($user, $organization, 'membershipLevels');
    }

    /**
     * Determine whether the user can modify the default membership level.
     *
     * @param User         $user
     * @param Organization $organization
     *
     * @return bool
     */
    public function modifyDefaultMembershipLevel(User $user, Organization $organization)
    {
        return $this->modifyRelationship($user, $organization, 'membershipLevels');
    }
}
