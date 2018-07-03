<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\FleetType;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FleetTypePolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the fleet type.
     *
     * @param User    $user
     * @param Model   $fleetType
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $fleetType, Request $request): bool
    {
        /* @var FleetType $fleetType */
        return $this->authorizeRelation($fleetType->organization, 'fleet_types', 'read', $request);
    }

    /**
     * Determine whether the user can create fleet types.
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
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

        return $this->authorizeRelation($organization, 'fleet_types', 'modify', $request);
    }

    /**
     * Determine whether the user can update the fleet type.
     *
     * @param User    $user
     * @param Model   $fleetType
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $fleetType, Request $request): bool
    {
        /* @var FleetType $fleetType */
        return $this->authorizeRelation($fleetType->organization, 'fleet_types', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the fleet type.
     *
     * @param User    $user
     * @param Model   $fleetType
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $fleetType, Request $request): bool
    {
        /* @var FleetType $fleetType */
        return $this->authorizeRelation($fleetType->organization, 'fleet_types', 'modify', $request);
    }

    /**
     * @param FleetType $fleetType
     * @param Request   $request
     *
     * @return bool
     */
    public function readOrganization(FleetType $fleetType, Request $request): bool
    {
        return $request->user()->can('read', [$fleetType->organization, $request]);
    }

    /**
     * @param FleetType $fleetType
     * @param Request   $request
     *
     * @return bool
     */
    public function modifyOrganization(FleetType $fleetType, Request $request): bool
    {
        return false;
    }

    /**
     * @param FleetType $fleetType
     * @param Request   $request
     *
     * @return bool
     */
    public function readFleets(FleetType $fleetType, Request $request): bool
    {
        return $request->user()->can('read', [$fleetType->organization, $request]);
    }

    /**
     * @param FleetType $fleetType
     * @param Request   $request
     *
     * @return bool
     */
    public function modifyFleets(FleetType $fleetType, Request $request): bool
    {
        return false;
    }
}
