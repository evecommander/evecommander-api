<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Membership;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesNotificationsRelation;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class MembershipPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations, AuthorizesNotificationsRelation;

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
     * Determine whether the user can view the membership.
     *
     * @param User  $user
     * @param Model $membership
     *
     * @return bool
     */
    public function read(User $user, Model $membership): bool
    {
        /* @var Membership $membership */
        return $this->readRelationship($user, $membership->organization, 'members') ||
            $this->readRelationship($user, $membership->member, 'memberships');
    }

    /**
     * Determine whether the user can create memberships.
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

        return $this->modifyRelationship($user, $organization, 'memberships');
    }

    /**
     * Determine whether the user can update the membership.
     *
     * @param User  $user
     * @param Model $membership
     *
     * @return bool
     */
    public function update(User $user, Model $membership): bool
    {
        /* @var Membership $membership */
        return $this->modifyRelationship($user, $membership->organization, 'members') ||
            $this->modifyRelationship($user, $membership->member, 'memberships');
    }

    /**
     * Determine whether the user can delete the membership.
     *
     * @param User  $user
     * @param Model $membership
     *
     * @return bool
     */
    public function delete(User $user, Model $membership): bool
    {
        /* @var Membership $membership */
        return $this->modifyRelationship($user, $membership->organization, 'members') ||
            $this->modifyRelationship($user, $membership->member, 'memberships');
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function readOrganization(User $user, Membership $membership): bool
    {
        return $user->can('read', [$membership->organization]);
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function modifyOrganization(User $user, Membership $membership): bool
    {
        return false;
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function readMembershipLevel(User $user, Membership $membership): bool
    {
        return $this->read($user, $membership);
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function modifyMembershipLevel(User $user, Membership $membership): bool
    {
        return $this->update($user, $membership);
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function readMember(User $user, Membership $membership): bool
    {
        return $this->read($user, $membership);
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function modifyMember(User $user, Membership $membership): bool
    {
        return false;
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function readCreatedBy(User $user, Membership $membership): bool
    {
        return $this->read($user, $membership);
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function modifyCreatedBy(User $user, Membership $membership): bool
    {
        return false;
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function readLastUpdatedBy(User $user, Membership $membership): bool
    {
        return $this->read($user, $membership);
    }

    /**
     * @param User       $user
     * @param Membership $membership
     *
     * @return bool
     */
    public function modifyLastUpdatedBy(User $user, Membership $membership): bool
    {
        return false;
    }
}
