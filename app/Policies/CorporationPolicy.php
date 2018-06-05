<?php

namespace App\Policies;

use App\User;
use App\Corporation;
use Illuminate\Auth\Access\HandlesAuthorization;

class CorporationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the corporation.
     *
     * @param  \App\User  $user
     * @param  \App\Corporation  $corporation
     * @return mixed
     */
    public function view(User $user, Corporation $corporation)
    {
        //
    }

    /**
     * Determine whether the user can create corporations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the corporation.
     *
     * @param  \App\User  $user
     * @param  \App\Corporation  $corporation
     * @return mixed
     */
    public function update(User $user, Corporation $corporation)
    {
        //
    }

    /**
     * Determine whether the user can delete the corporation.
     *
     * @param  \App\User  $user
     * @param  \App\Corporation  $corporation
     * @return mixed
     */
    public function delete(User $user, Corporation $corporation)
    {
        //
    }
}
