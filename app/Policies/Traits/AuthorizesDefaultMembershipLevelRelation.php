<?php

namespace App\Policies\Traits;

use App\Abstracts\Organization;
use Illuminate\Http\Request;

trait AuthorizesDefaultMembershipLevelRelation
{
    /**
     * Determine whether the user can read the default membership level.
     *
     * @param Organization $organization
     * @param Request $request
     *
     * @return bool
     */
    public function readDefaultMembershipLevel(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'membershipLevels', 'read', $request);
    }

    /**
     * Determine whether the user can modify the default membership level.
     *
     * @param Organization $organization
     * @param Request $request
     *
     * @return bool
     */
    public function modifyDefaultMembershipLevel(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'membershipLevels', 'modify', $request);
    }
}