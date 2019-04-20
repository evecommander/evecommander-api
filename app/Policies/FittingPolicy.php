<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Fitting;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class FittingPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the fitting.
     *
     * @param User  $user
     * @param Model $fitting
     *
     * @return bool
     */
    public function read(User $user, Model $fitting): bool
    {
        /* @var Fitting $fitting */
        return $this->readRelationship($user, $fitting->organization, 'fittings');
    }

    /**
     * Determine whether the user can create fittings.
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

        return $this->modifyRelationship($user, $organization, 'fittings');
    }

    /**
     * Determine whether the user can update the fitting.
     *
     * @param User  $user
     * @param Model $fitting
     *
     * @return bool
     */
    public function update(User $user, Model $fitting): bool
    {
        /* @var Fitting $fitting */
        return $this->modifyRelationship($user, $fitting->organization, 'fittings');
    }

    /**
     * Determine whether the user can delete the fitting.
     *
     * @param User  $user
     * @param Model $fitting
     *
     * @return bool
     */
    public function delete(User $user, Model $fitting): bool
    {
        /* @var Fitting $fitting */
        return $this->modifyRelationship($user, $fitting->organization, 'fittings');
    }

    /**
     * @param User    $user
     * @param Fitting $fitting
     *
     * @return bool
     */
    public function readOrganization(User $user, Fitting $fitting): bool
    {
        return $user->can('read', [$fitting->organization]);
    }

    /**
     * @param User    $user
     * @param Fitting $fitting
     *
     * @return bool
     */
    public function modifyOrganization(User $user, Fitting $fitting): bool
    {
        return false;
    }

    /**
     * @param User    $user
     * @param Fitting $fitting
     *
     * @return bool
     */
    public function readDoctrine(User $user, Fitting $fitting): bool
    {
        return $user->can('read', [$fitting->organization]);
    }

    /**
     * @param User    $user
     * @param Fitting $fitting
     *
     * @return bool
     */
    public function modifyDoctrine(User $user, Fitting $fitting): bool
    {
        return false;
    }

    /**
     * @param User    $user
     * @param Fitting $fitting
     *
     * @return bool
     */
    public function readReplacementClaims(User $user, Fitting $fitting): bool
    {
        return $user->can('read', [$fitting->organization]);
    }

    /**
     * @param User    $user
     * @param Fitting $fitting
     *
     * @return bool
     */
    public function modifyReplacementClaims(User $user, Fitting $fitting): bool
    {
        return false;
    }
}
