<?php

namespace App\Policies;

use App\User;
use App\Fleet;
use Illuminate\Auth\Access\HandlesAuthorization;

class FleetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the fleet.
     *
     * @param  \App\User  $user
     * @param  \App\Fleet  $fleet
     * @return mixed
     */
    public function view(User $user, Fleet $fleet)
    {
        //
    }

    /**
     * Determine whether the user can create fleets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the fleet.
     *
     * @param  \App\User  $user
     * @param  \App\Fleet  $fleet
     * @return mixed
     */
    public function update(User $user, Fleet $fleet)
    {
        //
    }

    /**
     * Determine whether the user can delete the fleet.
     *
     * @param  \App\User  $user
     * @param  \App\Fleet  $fleet
     * @return mixed
     */
    public function delete(User $user, Fleet $fleet)
    {
        //
    }
}
