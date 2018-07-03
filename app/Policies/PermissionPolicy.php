<?php

namespace App\Policies;

use App\Permission;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PermissionPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the permission.
     *
     * @param User    $user
     * @param Model   $permission
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $permission, Request $request): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create permissions.
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the permission.
     *
     * @param User    $user
     * @param Model   $permission
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $permission, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the permission.
     *
     * @param User    $user
     * @param Model   $permission
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $permission, Request $request): bool
    {
        return false;
    }

    /**
     * @param Permission $permission
     * @param Request    $request
     *
     * @return bool
     */
    public function readMembershipLevels(Permission $permission, Request $request): bool
    {
        return false;
    }

    /**
     * @param Permission $permission
     * @param Request    $request
     *
     * @return bool
     */
    public function modifyMembershipLevels(Permission $permission, Request $request): bool
    {
        return false;
    }

    /**
     * @param Permission $permission
     * @param Request    $request
     *
     * @return bool
     */
    public function readRoles(Permission $permission, Request $request): bool
    {
        return false;
    }

    /**
     * @param Permission $permission
     * @param Request    $request
     *
     * @return bool
     */
    public function modifyRoles(Permission $permission, Request $request): bool
    {
        return false;
    }
}
