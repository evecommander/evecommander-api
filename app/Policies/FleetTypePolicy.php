<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\FleetType;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class FleetTypePolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the fleet type.
     *
     * @param User  $user
     * @param Model $fleetType
     *
     * @return bool
     */
    public function read(User $user, Model $fleetType): bool
    {
        /* @var FleetType $fleetType */
        return $this->readRelationship($user, $fleetType->organization, 'fleet_types');
    }

    /**
     * Determine whether the user can create fleet types.
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

        return $this->modifyRelationship($user, $organization, 'fleet_types');
    }

    /**
     * Determine whether the user can update the fleet type.
     *
     * @param User  $user
     * @param Model $fleetType
     *
     * @return bool
     */
    public function update(User $user, Model $fleetType): bool
    {
        /* @var FleetType $fleetType */
        return $this->modifyRelationship($user, $fleetType->organization, 'fleet_types');
    }

    /**
     * Determine whether the user can delete the fleet type.
     *
     * @param User  $user
     * @param Model $fleetType
     *
     * @return bool
     */
    public function delete(User $user, Model $fleetType): bool
    {
        /* @var FleetType $fleetType */
        return $this->modifyRelationship($user, $fleetType->organization, 'fleet_types');
    }

    /**
     * @param User      $user
     * @param FleetType $fleetType
     *
     * @return bool
     */
    public function readOrganization(User $user, FleetType $fleetType): bool
    {
        return $user->can('read', [$fleetType->organization]);
    }

    /**
     * @param User      $user
     * @param FleetType $fleetType
     *
     * @return bool
     */
    public function modifyOrganization(User $user, FleetType $fleetType): bool
    {
        return false;
    }

    /**
     * @param User      $user
     * @param FleetType $fleetType
     *
     * @return bool
     */
    public function readFleets(User $user, FleetType $fleetType): bool
    {
        return $user->can('read', [$fleetType->organization]);
    }

    /**
     * @param User      $user
     * @param FleetType $fleetType
     *
     * @return bool
     */
    public function modifyFleets(User $user, FleetType $fleetType): bool
    {
        return false;
    }
}
