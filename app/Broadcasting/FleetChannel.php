<?php

namespace App\Broadcasting;

use App\Fleet;
use App\User;

class FleetChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @param  \App\Fleet $fleet
     * @return array|bool
     */
    public function join(User $user, Fleet $fleet)
    {
        return $user->can('read', [$fleet, request()]);
    }
}
