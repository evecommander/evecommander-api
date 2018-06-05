<?php

namespace App\Policies;

use App\User;
use App\Fitting;
use Illuminate\Auth\Access\HandlesAuthorization;

class FittingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the fitting.
     *
     * @param  \App\User  $user
     * @param  \App\Fitting  $fitting
     * @return mixed
     */
    public function view(User $user, Fitting $fitting)
    {
        //
    }

    /**
     * Determine whether the user can create fittings.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the fitting.
     *
     * @param  \App\User  $user
     * @param  \App\Fitting  $fitting
     * @return mixed
     */
    public function update(User $user, Fitting $fitting)
    {
        //
    }

    /**
     * Determine whether the user can delete the fitting.
     *
     * @param  \App\User  $user
     * @param  \App\Fitting  $fitting
     * @return mixed
     */
    public function delete(User $user, Fitting $fitting)
    {
        //
    }
}
