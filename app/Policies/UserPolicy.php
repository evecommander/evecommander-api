<?php

namespace App\Policies;

use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class UserPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the model.
     *
     * @param User  $user
     * @param Model $requestedUser
     *
     * @return bool
     */
    public function read(User $user, Model $requestedUser): bool
    {
        /* @var User $requestedUser */
        return $user->is($requestedUser);
    }

    /**
     * Determine whether the user can create models.
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
     * Determine whether the user can update the model.
     *
     * @param User  $user
     * @param Model $requestedUser
     *
     * @return bool
     */
    public function update(User $user, Model $requestedUser): bool
    {
        /* @var User $requestedUser */
        return $user->is($requestedUser);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User  $user
     * @param Model $requestedUser
     *
     * @return bool
     */
    public function delete(User $user, Model $requestedUser): bool
    {
        /* @var User $requestedUser */
        return $user->is($requestedUser);
    }

    /**
     * @param User $user
     * @param User $requestedUser
     *
     * @return bool
     */
    public function readCharacters(User $user, User $requestedUser): bool
    {
        return $this->read($user, $requestedUser);
    }

    /**
     * @param User $user
     * @param User $requestedUser
     *
     * @return bool
     */
    public function modifyCharacters(User $user, User $requestedUser): bool
    {
        return false;
    }

    /**
     * @param User $user
     * @param User $requestedUser
     *
     * @return bool
     */
    public function readNotifications(User $user, User $requestedUser): bool
    {
        return $user->is($requestedUser);
    }

    /**
     * @param User $user
     * @param User $requestedUser
     *
     * @return bool
     */
    public function modifyNotifications(User $user, User $requestedUser): bool
    {
        return $user->is($requestedUser);
    }

    /**
     * @param User $user
     * @param User $requestedUser
     *
     * @return bool
     */
    public function readReadNotifications(User $user, User $requestedUser): bool
    {
        return $user->is($requestedUser);
    }

    /**
     * @param User $user
     * @param User $requestedUser
     *
     * @return bool
     */
    public function modifyReadNotifications(User $user, User $requestedUser): bool
    {
        return $user->is($requestedUser);
    }

    /**
     * @param User $user
     * @param User $requestedUser
     *
     * @return bool
     */
    public function readUnreadNotifications(User $user, User $requestedUser): bool
    {
        return $user->is($requestedUser);
    }

    /**
     * @param User $user
     * @param User $requestedUser
     *
     * @return bool
     */
    public function modifyUnreadNotifications(User $user, User $requestedUser): bool
    {
        return $user->is($requestedUser);
    }
}
