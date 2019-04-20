<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class RolePolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the role.
     *
     * @param User    $user
     * @param Model   $role
     *
     * @return bool
     */
    public function read(User $user, Model $role): bool
    {
        /* @var Role $role */
        return $this->readRelationship($user, $role->organization, 'roles');
    }

    /**
     * Determine whether the user can create roles.
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

        return $this->modifyRelationship($user, $organization, 'roles');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param User    $user
     * @param Model   $role
     *
     * @return bool
     */
    public function update(User $user, Model $role): bool
    {
        /* @var Role $role */
        return $this->modifyRelationship($user, $role->organization, 'roles');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param User    $user
     * @param Model   $role
     *
     * @return bool
     */
    public function delete(User $user, Model $role): bool
    {
        /* @var Role $role */
        return $this->modifyRelationship($user, $role->organization, 'roles');
    }

    /**
     * @param User    $user
     * @param Role    $role
     *
     * @return bool
     */
    public function readOrganization(User $user, Role $role): bool
    {
        return $user->can('read', [$role->organization]);
    }

    /**
     * @param User    $user
     * @param Role    $role
     *
     * @return bool
     */
    public function modifyOrganization(User $user, Role $role): bool
    {
        return false;
    }

    /**
     * @param User    $user
     * @param Role    $role
     *
     * @return bool
     */
    public function readPermissions(User $user, Role $role): bool
    {
        return $this->read($user, $role);
    }

    /**
     * @param User    $user
     * @param Role    $role
     *
     * @return bool
     */
    public function modifyPermissions(User $user, Role $role): bool
    {
        return $this->update($user, $role);
    }

    /**
     * @param User    $user
     * @param Role    $role
     *
     * @return bool
     */
    public function readCharacters(User $user, Role $role): bool
    {
        return $this->read($user, $role);
    }

    /**
     * @param User    $user
     * @param Role    $role
     *
     * @return bool
     */
    public function modifyCharacters(User $user, Role $role): bool
    {
        return false;
    }

    /**
     * @param User    $user
     * @param Role    $role
     *
     * @return bool
     */
    public function readMembershipLevels(User $user, Role $role): bool
    {
        return $this->read($user, $role);
    }

    /**
     * @param User    $user
     * @param Role    $role
     *
     * @return bool
     */
    public function modifyMembershipLevels(User $user, Role $role): bool
    {
        return false;
    }
}
