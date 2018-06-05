<?php

namespace App\Policies;

use App\User;
use App\Alliance;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlliancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the alliance.
     *
     * @param  \App\User  $user
     * @param  \App\Alliance  $alliance
     * @return mixed
     */
    public function view(User $user, Alliance $alliance)
    {
        //
    }

    /**
     * Determine whether the user can create alliances.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the odel= alliance.
     *
     * @param  \App\User  $user
     * @param  \App\Alliance  $alliance
     * @return mixed
     */
    public function update(User $user, Alliance $alliance)
    {
        //
    }

    /**
     * Determine whether the user can delete the odel= alliance.
     *
     * @param  \App\User  $user
     * @param  \App\Alliance  $alliance
     * @return mixed
     */
    public function delete(User $user, Alliance $alliance)
    {
        //
    }
}
