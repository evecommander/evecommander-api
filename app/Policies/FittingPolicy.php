<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\Fitting;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FittingPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the fitting.
     *
     * @param  User    $user
     * @param  Model   $fitting
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $fitting, Request $request): bool
    {
        /** @var Fitting $fitting */
        return $this->authorizeRelation($fitting->organization, 'fittings', 'read', $request);
    }

    /**
     * Determine whether the user can create fittings.
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

        return $this->authorizeRelation($organization, 'fittings', 'modify', $request);
    }

    /**
     * Determine whether the user can update the fitting.
     *
     * @param  User    $user
     * @param  Model   $fitting
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $fitting, Request $request): bool
    {
        /** @var Fitting $fitting */
        return $this->authorizeRelation($fitting->organization, 'fittings', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the fitting.
     *
     * @param  User    $user
     * @param  Model   $fitting
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $fitting, Request $request): bool
    {
        /** @var Fitting $fitting */
        return $this->authorizeRelation($fitting->organization, 'fittings', 'modify', $request);
    }

    /**
     * @param Fitting $fitting
     * @param Request $request
     * @return bool
     */
    public function readOrganization(Fitting $fitting, Request $request): bool
    {
        return $request->user()->can('read', [$fitting->organization, $request]);
    }

    /**
     * @param Fitting $fitting
     * @param Request $request
     * @return bool
     */
    public function modifyOrganization(Fitting $fitting, Request $request): bool
    {
        return false;
    }

    /**
     * @param Fitting $fitting
     * @param Request $request
     * @return bool
     */
    public function readDoctrine(Fitting $fitting, Request $request): bool
    {
        return $request->user()->can('read', [$fitting->organization, $request]);
    }

    /**
     * @param Fitting $fitting
     * @param Request $request
     * @return bool
     */
    public function modifyDoctrine(Fitting $fitting, Request $request): bool
    {
        return false;
    }

    /**
     * @param Fitting $fitting
     * @param Request $request
     * @return bool
     */
    public function readReplacementClaims(Fitting $fitting, Request $request): bool
    {
        return $request->user()->can('read', [$fitting->organization, $request]);
    }

    /**
     * @param Fitting $fitting
     * @param Request $request
     * @return bool
     */
    public function modifyReplacementClaims(Fitting $fitting, Request $request): bool
    {
        return false;
    }
}
