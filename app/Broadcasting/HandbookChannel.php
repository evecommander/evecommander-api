<?php

namespace App\Broadcasting;

use App\Handbook;
use App\User;

class HandbookChannel
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
     * @param \App\User     $user
     * @param \App\Handbook $handbook
     *
     * @return array|bool
     */
    public function join(User $user, Handbook $handbook)
    {
        return $user->can('read', [$handbook, request()]);
    }
}
