<?php

namespace App\Policies\Traits;

use App\Abstracts\Organization;
use App\User;

trait AuthorizesMembershipsRelation
{
    /**
     * @param User         $user
     * @param Organization $organization
     *
     * @return bool
     */
    public function modifyMembers(User $user, Organization $organization)
    {
        return $this->modifyRelationship($user, $organization, 'memberships');
    }
}
