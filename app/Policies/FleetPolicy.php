<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Fleet;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesNotificationsRelation;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class FleetPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the doctrine.
     *
     * @param User  $user
     * @param Model $fleet
     *
     * @return bool
     */
    public function read(User $user, Model $fleet): bool
    {
        /* @var Fleet $fleet */
        return $this->readRelationship($user, $fleet->organization, 'fleets');
    }

    /**
     * Determine whether the user can create fleets.
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

        return $this->modifyRelationship($user, $organization, 'fleets');
    }

    /**
     * Determine whether the user can update the fleet.
     *
     * @param User  $user
     * @param Model $fleet
     *
     * @return bool
     */
    public function update(User $user, Model $fleet): bool
    {
        /* @var Fleet $fleet */
        return $this->modifyRelationship($user, $fleet->organization, 'fleets');
    }

    /**
     * Determine whether the user can delete the fleet.
     *
     * @param User  $user
     * @param Model $fleet
     *
     * @return bool
     */
    public function delete(User $user, Model $fleet): bool
    {
        /* @var Fleet $fleet */
        return $this->modifyRelationship($user, $fleet->organization, 'fleets');
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function readOrganization(User $user, Fleet $fleet): bool
    {
        return $user->can('read', [$fleet->organization]);
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function modifyOrganization(User $user, Fleet $fleet): bool
    {
        return false;
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function readComments(User $user, Fleet $fleet): bool
    {
        return $user->can('read', [$fleet->organization]);
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function modifyComments(User $user, Fleet $fleet): bool
    {
        return false;
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function readFleetType(User $user, Fleet $fleet): bool
    {
        return $user->can('read', [$fleet->organization]);
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function modifyFleetType(User $user, Fleet $fleet): bool
    {
        return false;
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function readCreatedBy(User $user, Fleet $fleet): bool
    {
        return $user->can('read', [$fleet->organization]);
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function modifyCreatedBy(User $user, Fleet $fleet): bool
    {
        return false;
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function readLastUpdatedBy(User $user, Fleet $fleet): bool
    {
        return $user->can('read', [$fleet->organization]);
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function modifyLastUpdatedBy(User $user, Fleet $fleet): bool
    {
        return false;
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function readRsvps(User $user, Fleet $fleet): bool
    {
        return $user->can('read', [$fleet->organization]);
    }

    /**
     * @param User  $user
     * @param Fleet $fleet
     *
     * @return bool
     */
    public function modifyRsvps(User $user, Fleet $fleet): bool
    {
        return false;
    }
}
