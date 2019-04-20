<?php

namespace App\Policies;

use App\OAuth2Token;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class OAuth2TokenPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the o auth2 token.
     *
     * @param User  $user
     * @param Model $oAuth2Token
     *
     * @return bool
     */
    public function read(User $user, Model $oAuth2Token): bool
    {
        /* @var OAuth2Token $oAuth2Token */
        return $oAuth2Token->character()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create o auth2 tokens.
     *
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the o auth2 token.
     *
     * @param User  $user
     * @param Model $oAuth2Token
     *
     * @return bool
     */
    public function update(User $user, Model $oAuth2Token): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the o auth2 token.
     *
     * @param User  $user
     * @param Model $oAuth2Token
     *
     * @return bool
     */
    public function delete(User $user, Model $oAuth2Token): bool
    {
        return false;
    }

    /**
     * @param User        $user
     * @param OAuth2Token $OAuth2Token
     *
     * @return bool
     */
    public function readCharacter(User $user, OAuth2Token $OAuth2Token): bool
    {
        return $this->read($user, $OAuth2Token);
    }

    /**
     * @param User        $user
     * @param OAuth2Token $OAuth2Token
     *
     * @return bool
     */
    public function modifyCharacter(User $user, OAuth2Token $OAuth2Token): bool
    {
        return false;
    }
}
