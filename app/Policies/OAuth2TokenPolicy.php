<?php

namespace App\Policies;

use App\User;
use App\OAuth2Token;
use Illuminate\Auth\Access\HandlesAuthorization;

class OAuth2TokenPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the o auth2 token.
     *
     * @param  \App\User  $user
     * @param  \App\OAuth2Token  $oAuth2Token
     * @return mixed
     */
    public function view(User $user, OAuth2Token $oAuth2Token)
    {
        //
    }

    /**
     * Determine whether the user can create o auth2 tokens.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the o auth2 token.
     *
     * @param  \App\User  $user
     * @param  \App\OAuth2Token  $oAuth2Token
     * @return mixed
     */
    public function update(User $user, OAuth2Token $oAuth2Token)
    {
        //
    }

    /**
     * Determine whether the user can delete the o auth2 token.
     *
     * @param  \App\User  $user
     * @param  \App\OAuth2Token  $oAuth2Token
     * @return mixed
     */
    public function delete(User $user, OAuth2Token $oAuth2Token)
    {
        //
    }
}
