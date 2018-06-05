<?php

namespace App\Policies;

use App\User;
use App\FleetType;
use Illuminate\Auth\Access\HandlesAuthorization;

class FleetTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the fleet type.
     *
     * @param  \App\User  $user
     * @param  \App\FleetType  $fleetType
     * @return mixed
     */
    public function view(User $user, FleetType $fleetType)
    {
        //
    }

    /**
     * Determine whether the user can create fleet types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the fleet type.
     *
     * @param  \App\User  $user
     * @param  \App\FleetType  $fleetType
     * @return mixed
     */
    public function update(User $user, FleetType $fleetType)
    {
        //
    }

    /**
     * Determine whether the user can delete the fleet type.
     *
     * @param  \App\User  $user
     * @param  \App\FleetType  $fleetType
     * @return mixed
     */
    public function delete(User $user, FleetType $fleetType)
    {
        //
    }
}
