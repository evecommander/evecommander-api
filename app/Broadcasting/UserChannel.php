<?php

namespace App\Broadcasting;

use App\User;

class UserChannel
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
     * @param \App\User $authenticatedUser
     * @param \App\User $channelUser
     *
     * @return array|bool
     */
    public function join(User $authenticatedUser, User $channelUser)
    {
        return $authenticatedUser->is($channelUser);
    }
}
