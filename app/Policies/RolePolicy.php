<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RolePolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the role.
     *
     * @param User    $user
     * @param Model   $role
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $role, Request $request): bool
    {
        /* @var Role $role */
        return $this->authorizeRelation($role->organization, 'roles', 'read', $request);
    }

    /**
     * Determine whether the user can create roles.
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

        return $this->authorizeRelation($organization, 'roles', 'modify', $request);
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param User    $user
     * @param Model   $role
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $role, Request $request): bool
    {
        /* @var Role $role */
        return $this->authorizeRelation($role->organization, 'roles', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param User    $user
     * @param Model   $role
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $role, Request $request): bool
    {
        /* @var Role $role */
        return $this->authorizeRelation($role->organization, 'roles', 'modify', $request);
    }

    /**
     * @param Role    $role
     * @param Request $request
     *
     * @return bool
     */
    public function readOrganization(Role $role, Request $request): bool
    {
        return $request->user()->can('read', [$role->organization, $request]);
    }

    /**
     * @param Role    $role
     * @param Request $request
     *
     * @return bool
     */
    public function modifyOrganization(Role $role, Request $request): bool
    {
        return false;
    }

    /**
     * @param Role    $role
     * @param Request $request
     *
     * @return bool
     */
    public function readPermissions(Role $role, Request $request): bool
    {
        return $this->read($request->user(), $role, $request);
    }

    /**
     * @param Role    $role
     * @param Request $request
     *
     * @return bool
     */
    public function modifyPermissions(Role $role, Request $request): bool
    {
        return $this->update($request->user(), $role, $request);
    }

    /**
     * @param Role    $role
     * @param Request $request
     *
     * @return bool
     */
    public function readCharacters(Role $role, Request $request): bool
    {
        return $this->read($request->user(), $role, $request);
    }

    /**
     * @param Role    $role
     * @param Request $request
     *
     * @return bool
     */
    public function modifyCharacters(Role $role, Request $request): bool
    {
        return false;
    }
}
