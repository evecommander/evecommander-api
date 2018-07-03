<?php

namespace App\Policies;

use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the model.
     *
     * @param User    $user
     * @param Model   $requestedUser
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $requestedUser, Request $request): bool
    {
        /* @var User $requestedUser */
        return $user->id === $requestedUser->id;
    }

    /**
     * Determine whether the user can create models.
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
     * Determine whether the user can update the model.
     *
     * @param User    $user
     * @param Model   $requestedUser
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $requestedUser, Request $request): bool
    {
        /* @var User $requestedUser */
        return $user->id === $requestedUser->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User    $user
     * @param Model   $requestedUser
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $requestedUser, Request $request): bool
    {
        /* @var User $requestedUser */
        return $user->id === $requestedUser->id;
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return bool
     */
    public function readCharacters(User $user, Request $request): bool
    {
        return $this->read($request->user(), $user, $request);
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return bool
     */
    public function modifyCharacters(User $user, Request $request): bool
    {
        return false;
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return bool
     */
    public function readNotifications(User $user, Request $request): bool
    {
        return $request->user()->id === $user->id;
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return bool
     */
    public function modifyNotifications(User $user, Request $request): bool
    {
        return $request->user()->id === $user->id;
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return bool
     */
    public function readReadNotifications(User $user, Request $request): bool
    {
        return $request->user()->id === $user->id;
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return bool
     */
    public function modifyReadNotifications(User $user, Request $request): bool
    {
        return $request->user()->id === $user->id;
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return bool
     */
    public function readUnreadNotifications(User $user, Request $request): bool
    {
        return $request->user()->id === $user->id;
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return bool
     */
    public function modifyUnreadNotifications(User $user, Request $request): bool
    {
        return $request->user()->id === $user->id;
    }
}
