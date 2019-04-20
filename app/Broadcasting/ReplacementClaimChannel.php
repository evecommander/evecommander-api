<?php

namespace App\Broadcasting;

use App\ReplacementClaim;
use App\User;

class ReplacementClaimChannel
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
     * @param \App\User             $user
     * @param \App\ReplacementClaim $replacementClaim
     *
     * @return array|bool
     */
    public function join(User $user, ReplacementClaim $replacementClaim)
    {
        return $user->can('read', [$replacementClaim, request()]);
    }
}
