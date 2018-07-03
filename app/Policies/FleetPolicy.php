<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesNotificationsRelation;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\Fleet;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FleetPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the doctrine.
     *
     * @param  User    $user
     * @param  Model   $fleet
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $fleet, Request $request): bool
    {
        /** @var Fleet $fleet */
        return $this->authorizeRelation($fleet->organization, 'fleets', 'read', $request);
    }

    /**
     * Determine whether the user can create fleets.
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

        return $this->authorizeRelation($organization, 'fleets', 'modify', $request);
    }

    /**
     * Determine whether the user can update the fleet.
     *
     * @param  User    $user
     * @param  Model   $fleet
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $fleet, Request $request): bool
    {
        /** @var Fleet $fleet */
        return $this->authorizeRelation($fleet->organization, 'fleets', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the fleet.
     *
     * @param  User    $user
     * @param  Model   $fleet
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $fleet, Request $request): bool
    {
        /** @var Fleet $fleet */
        return $this->authorizeRelation($fleet->organization, 'fleets', 'modify', $request);
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function readOrganization(Fleet $fleet, Request $request): bool
    {
        return $request->user()->can('read', [$fleet->organization, $request]);
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function modifyOrganization(Fleet $fleet, Request $request): bool
    {
        return false;
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function readComments(Fleet $fleet, Request $request): bool
    {
        return $request->user()->can('read', [$fleet->organization, $request]);
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function modifyComments(Fleet $fleet, Request $request): bool
    {
        return false;
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function readFleetType(Fleet $fleet, Request $request): bool
    {
        return $request->user()->can('read', [$fleet->organization, $request]);
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function modifyFleetType(Fleet $fleet, Request $request): bool
    {
        return false;
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function readCreatedBy(Fleet $fleet, Request $request): bool
    {
        return $request->user()->can('read', [$fleet->organization, $request]);
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function modifyCreatedBy(Fleet $fleet, Request $request): bool
    {
        return false;
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function readLastUpdatedBy(Fleet $fleet, Request $request): bool
    {
        return $request->user()->can('read', [$fleet->organization, $request]);
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function modifyLastUpdatedBy(Fleet $fleet, Request $request): bool
    {
        return false;
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function readRsvps(Fleet $fleet, Request $request): bool
    {
        return $request->user()->can('read', [$fleet->organization, $request]);
    }

    /**
     * @param Fleet $fleet
     * @param Request $request
     * @return bool
     */
    public function modifyRsvps(Fleet $fleet, Request $request): bool
    {
        return false;
    }
}
