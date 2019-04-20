<?php

namespace App\Policies;

use App\Permission;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class PermissionPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the permission.
     *
     * @param User  $user
     * @param Model $permission
     *
     * @return bool
     */
    public function read(User $user, Model $permission): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create permissions.
     *
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the permission.
     *
     * @param User  $user
     * @param Model $permission
     *
     * @return bool
     */
    public function update(User $user, Model $permission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the permission.
     *
     * @param User  $user
     * @param Model $permission
     *
     * @return bool
     */
    public function delete(User $user, Model $permission): bool
    {
        return false;
    }

    /**
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function readMembershipLevels(User $user, Permission $permission): bool
    {
        return false;
    }

    /**
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function modifyMembershipLevels(User $user, Permission $permission): bool
    {
        return false;
    }

    /**
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function readRoles(User $user, Permission $permission): bool
    {
        return false;
    }

    /**
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function modifyRoles(User $user, Permission $permission): bool
    {
        return false;
    }
}
