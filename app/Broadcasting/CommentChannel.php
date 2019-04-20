<?php

namespace App\Broadcasting;

use App\Comment;
use App\User;

class CommentChannel
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
     * @param  \App\User    $user
     * @param  \App\Comment $comment
     * @return array|bool
     */
    public function join(User $user, Comment $comment)
    {
        return $user->can('read', [$comment, request()]);
    }
}
