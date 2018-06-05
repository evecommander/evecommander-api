<?php

namespace App\Policies;

use App\User;
use App\Rsvp;
use Illuminate\Auth\Access\HandlesAuthorization;

class RsvpPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the rsvp.
     *
     * @param  \App\User  $user
     * @param  \App\Rsvp  $rsvp
     * @return mixed
     */
    public function view(User $user, Rsvp $rsvp)
    {
        //
    }

    /**
     * Determine whether the user can create rsvps.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the rsvp.
     *
     * @param  \App\User  $user
     * @param  \App\Rsvp  $rsvp
     * @return mixed
     */
    public function update(User $user, Rsvp $rsvp)
    {
        //
    }

    /**
     * Determine whether the user can delete the rsvp.
     *
     * @param  \App\User  $user
     * @param  \App\Rsvp  $rsvp
     * @return mixed
     */
    public function delete(User $user, Rsvp $rsvp)
    {
        //
    }
}
