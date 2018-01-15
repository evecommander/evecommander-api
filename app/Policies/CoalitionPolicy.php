<?php

namespace App\Policies;

use App\User;
use App\Coalition;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoalitionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the coalition.
     *
     * @param  \App\User  $user
     * @param  \App\Coalition  $coalition
     * @return mixed
     */
    public function view(User $user, Coalition $coalition)
    {
        if ($user->id === $coalition->leader()->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create coalitions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // no permissions required
        return true;
    }

    /**
     * Determine whether the user can update the coalition.
     *
     * @param  \App\User  $user
     * @param  \App\Coalition  $coalition
     * @return mixed
     */
    public function update(User $user, Coalition $coalition)
    {
        if ($user->id === $coalition->leader()->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the coalition.
     *
     * @param  \App\User  $user
     * @param  \App\Coalition  $coalition
     * @return mixed
     */
    public function delete(User $user, Coalition $coalition)
    {
        if ($user->id === $coalition->leader()->id) {
            return true;
        }

        return false;
    }
}
