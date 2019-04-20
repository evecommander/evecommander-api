<?php

namespace App\Broadcasting;

use App\Abstracts\Organization;
use App\User;

class OrganizationChannel
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
     * @param  \App\User                   $user
     * @param  \App\Abstracts\Organization $organization
     * @return array|bool
     */
    public function join(User $user, Organization $organization)
    {
        return $user->can('read', $organization);
    }
}
