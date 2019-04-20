<?php

namespace App\Broadcasting;

use App\Membership;
use App\User;

class MembershipChannel
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
     * @param  \App\User       $user
     * @param  \App\Membership $membership
     * @return array|bool
     */
    public function join(User $user, Membership $membership)
    {
        return $user->can('read', [$membership, request()]);
    }
}
