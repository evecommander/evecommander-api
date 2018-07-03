<?php

namespace App\Policies\Traits;

use App\Abstracts\Organization;
use Illuminate\Http\Request;

trait AuthorizesMembershipsRelation
{
    /**
     * @param Organization $organization
     * @param Request      $request
     *
     * @return bool
     */
    public function modifyMembers(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'memberships', 'modify', $request);
    }
}
