<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesNotificationsRelation;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\Membership;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MembershipPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations, AuthorizesNotificationsRelation;

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
     * Determine whether the user can view the membership.
     *
     * @param  User    $user
     * @param  Model   $membership
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $membership, Request $request): bool
    {
        /** @var Membership $membership */
        return $this->authorizeRelation($membership->organization, 'members', 'read', $request) ||
            $this->authorizeRelation($membership->member, 'memberships', 'read', $request) ||
            $membership->member_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * Determine whether the user can create memberships.
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

        return $this->authorizeRelation($organization, 'memberships', 'modify', $request);
    }

    /**
     * Determine whether the user can update the membership.
     *
     * @param  User    $user
     * @param  Model   $membership
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $membership, Request $request): bool
    {
        /** @var Membership $membership */
        return $this->authorizeRelation($membership->organization, 'members', 'modify', $request) ||
            $this->authorizeRelation($membership->member, 'memberships', 'modify', $request) ||
            $membership->member_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * Determine whether the user can delete the membership.
     *
     * @param  User    $user
     * @param  Model   $membership
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $membership, Request $request): bool
    {
        /** @var Membership $membership */
        return $this->authorizeRelation($membership->organization, 'members', 'modify', $request) ||
            $this->authorizeRelation($membership->member, 'memberships', 'modify', $request) ||
            $membership->member_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function readOrganization(Membership $membership, Request $request): bool
    {
        return $request->user()->can('read', [$membership->organization, $request]);
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function modifyOrganization(Membership $membership, Request $request): bool
    {
        return false;
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function readMembershipLevel(Membership $membership, Request $request): bool
    {
        return $this->read($request->user(), $membership, $request);
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function modifyMembershipLevel(Membership $membership, Request $request): bool
    {
        return $this->update($request->user(), $membership, $request);
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function readMember(Membership $membership, Request $request): bool
    {
        return $this->read($request->user(), $membership, $request);
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function modifyMember(Membership $membership, Request $request): bool
    {
        return false;
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function readCreatedBy(Membership $membership, Request $request): bool
    {
        return $this->read($request->user(), $membership, $request);
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function modifyCreatedBy(Membership $membership, Request $request): bool
    {
        return false;
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function readLastUpdatedBy(Membership $membership, Request $request): bool
    {
        return $this->read($request->user(), $membership, $request);
    }

    /**
     * @param Membership $membership
     * @param Request $request
     * @return bool
     */
    public function modifyLastUpdatedBy(Membership $membership, Request $request): bool
    {
        return false;
    }
}
