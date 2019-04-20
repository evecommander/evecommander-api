<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\MembershipLevel;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class MembershipLevelPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the membership level.
     *
     * @param User  $user
     * @param Model $membershipLevel
     *
     * @return bool
     */
    public function read(User $user, Model $membershipLevel): bool
    {
        /* @var MembershipLevel $membershipLevel */
        return $this->readRelationship($user, $membershipLevel->organization, 'membership_levels');
    }

    /**
     * Determine whether the user can create membership levels.
     *
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        $request = \request();

        // this is run before validation so reject bad requests
        if (!$request->has('organization_type') || !$request->has('organization_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('organization_type')::find($request->get('organization_id'));

        return $this->modifyRelationship($user, $organization, 'membership_levels');
    }

    /**
     * Determine whether the user can update the membership level.
     *
     * @param User  $user
     * @param Model $membershipLevel
     *
     * @return bool
     */
    public function update(User $user, Model $membershipLevel): bool
    {
        /* @var MembershipLevel $membershipLevel */
        return $this->modifyRelationship($user, $membershipLevel->organization, 'membership_levels');
    }

    /**
     * Determine whether the user can delete the membership level.
     *
     * @param User  $user
     * @param Model $membershipLevel
     *
     * @return bool
     */
    public function delete(User $user, Model $membershipLevel): bool
    {
        /* @var MembershipLevel $membershipLevel */
        return $this->modifyRelationship($user, $membershipLevel->organization, 'membership_levels');
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function readOrganization(User $user, MembershipLevel $membershipLevel): bool
    {
        return $user->can('read', [$membershipLevel->organization]);
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function modifyOrganization(User $user, MembershipLevel $membershipLevel): bool
    {
        return false;
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function readMemberships(User $user, MembershipLevel $membershipLevel): bool
    {
        return $user->can('read', [$membershipLevel->organization]);
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function modifyMemberships(User $user, MembershipLevel $membershipLevel): bool
    {
        return false;
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function readCreatedBy(User $user, MembershipLevel $membershipLevel): bool
    {
        return $user->can('read', [$membershipLevel->organization]);
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function modifyCreatedBy(User $user, MembershipLevel $membershipLevel): bool
    {
        return false;
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function readLastUpdatedBy(User $user, MembershipLevel $membershipLevel): bool
    {
        return $user->can('read', [$membershipLevel->organization]);
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function modifyLastUpdatedBy(User $user, MembershipLevel $membershipLevel): bool
    {
        return false;
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function readRoles(User $user, MembershipLevel $membershipLevel): bool
    {
        return $user->can('read', [$membershipLevel->organization]);
    }

    /**
     * @param User            $user
     * @param MembershipLevel $membershipLevel
     *
     * @return bool
     */
    public function modifyRoles(User $user, MembershipLevel $membershipLevel): bool
    {
        return false;
    }
}
