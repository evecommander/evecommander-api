<?php

namespace App\Broadcasting;

use App\Character;
use App\User;

class CharacterChannel
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
     * @param \App\User      $user
     * @param \App\Character $character
     *
     * @return array|bool
     */
    public function join(User $user, Character $character)
    {
        return $user->characters()->where('characters.id', '=', $character->id)->exists();
    }
}
