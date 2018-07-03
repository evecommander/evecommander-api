<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\MembershipLevel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MembershipLevelPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the membership level.
     *
     * @param  User    $user
     * @param  Model   $membershipLevel
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $membershipLevel, Request $request): bool
    {
        /** @var MembershipLevel $membershipLevel */
        return $this->authorizeRelation($membershipLevel->organization, 'membership_levels', 'read', $request);
    }

    /**
     * Determine whether the user can create membership levels.
     *
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        // this is run before validation so reject bad requests
        if (!$request->has('organization_type') || !$request->has('organization_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('organization_type')::find($request->get('organization_id'));

        return $this->authorizeRelation($organization, 'membership_levels', 'modify', $request);
    }

    /**
     * Determine whether the user can update the membership level.
     *
     * @param  User    $user
     * @param  Model   $membershipLevel
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $membershipLevel, Request $request): bool
    {
        /** @var MembershipLevel $membershipLevel */
        return $this->authorizeRelation($membershipLevel->organization, 'membership_levels', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the membership level.
     *
     * @param  User    $user
     * @param  Model   $membershipLevel
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $membershipLevel, Request $request): bool
    {
        /** @var MembershipLevel $membershipLevel */
        return $this->authorizeRelation($membershipLevel->organization, 'membership_levels', 'modify', $request);
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function readOrganization(MembershipLevel $membershipLevel, Request $request): bool
    {
        return $request->user()->can('read', [$membershipLevel->organization, $request]);
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function modifyOrganization(MembershipLevel $membershipLevel, Request $request): bool
    {
        return false;
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function readMemberships(MembershipLevel $membershipLevel, Request $request): bool
    {
        return $request->user()->can('read', [$membershipLevel->organization, $request]);
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function modifyMemberships(MembershipLevel $membershipLevel, Request $request): bool
    {
        return false;
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function readCreatedBy(MembershipLevel $membershipLevel, Request $request): bool
    {
        return $request->user()->can('read', [$membershipLevel->organization, $request]);
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function modifyCreatedBy(MembershipLevel $membershipLevel, Request $request): bool
    {
        return false;
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function readLastUpdatedBy(MembershipLevel $membershipLevel, Request $request): bool
    {
        return $request->user()->can('read', [$membershipLevel->organization, $request]);
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function modifyLastUpdatedBy(MembershipLevel $membershipLevel, Request $request): bool
    {
        return false;
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function readPermissions(MembershipLevel $membershipLevel, Request $request): bool
    {
        return $request->user()->can('read', [$membershipLevel->organization, $request]);
    }

    /**
     * @param MembershipLevel $membershipLevel
     * @param Request $request
     * @return bool
     */
    public function modifyPermissions(MembershipLevel $membershipLevel, Request $request): bool
    {
        return false;
    }
}
