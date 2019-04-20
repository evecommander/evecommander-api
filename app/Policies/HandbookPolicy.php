<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Handbook;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class HandbookPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User    $user
     * @param string  $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the handbook.
     *
     * @param User    $user
     * @param Model   $handbook
     *
     * @return bool
     */
    public function read(User $user, Model $handbook): bool
    {
        /* @var Handbook $handbook */
        return $this->readRelationship($user, $handbook->organization, 'handbooks');
    }

    /**
     * Determine whether the user can create handbooks.
     *
     * @param User    $user
     * @param string  $type
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
     * Determine whether the user can update the handbook.
     *
     * @param User    $user
     * @param Model   $handbook
     *
     * @return bool
     */
    public function update(User $user, Model $handbook): bool
    {
        /* @var Handbook $handbook */
        return $this->modifyRelationship($user, $handbook->organization, 'handbooks');
    }

    /**
     * Determine whether the user can delete the handbook.
     *
     * @param User    $user
     * @param Model   $handbook
     *
     * @return bool
     */
    public function delete(User $user, Model $handbook): bool
    {
        /* @var Handbook $handbook */
        return $this->modifyRelationship($user, $handbook->organization, 'handbooks');
    }

    /**
     * @param User     $user
     * @param Handbook $handbook
     *
     * @return bool
     */
    public function readOrganization(User $user, Handbook $handbook): bool
    {
        return $user->can('read', [$handbook->organization]);
    }

    /**
     * @param User     $user
     * @param Handbook $handbook
     *
     * @return bool
     */
    public function modifyOrganization(User $user, Handbook $handbook): bool
    {
        return false;
    }

    /**
     * @param User     $user
     * @param Handbook $handbook
     *
     * @return bool
     */
    public function readCreatedBy(User $user, Handbook $handbook): bool
    {
        return $user->can('read', [$handbook->organization]);
    }

    /**
     * @param User     $user
     * @param Handbook $handbook
     *
     * @return bool
     */
    public function modifyCreatedBy(User $user, Handbook $handbook): bool
    {
        return false;
    }

    /**
     * @param User     $user
     * @param Handbook $handbook
     *
     * @return bool
     */
    public function readLastUpdatedBy(User $user, Handbook $handbook): bool
    {
        return $user->can('read', [$handbook->organization]);
    }

    /**
     * @param User     $user
     * @param Handbook $handbook
     *
     * @return bool
     */
    public function modifyLastUpdatedBy(User $user, Handbook $handbook): bool
    {
        return false;
    }
}
