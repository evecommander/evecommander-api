<?php

namespace App\Policies;

use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\OAuth2Token;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OAuth2TokenPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the o auth2 token.
     *
     * @param  User    $user
     * @param  Model   $oAuth2Token
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $oAuth2Token, Request $request): bool
    {
        /** @var OAuth2Token $oAuth2Token */
        return $oAuth2Token->character_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * Determine whether the user can create o auth2 tokens.
     *
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the o auth2 token.
     *
     * @param  User    $user
     * @param  Model   $oAuth2Token
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $oAuth2Token, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the o auth2 token.
     *
     * @param  User    $user
     * @param  Model   $oAuth2Token
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $oAuth2Token, Request $request): bool
    {
        return false;
    }

    /**
     * @param OAuth2Token $OAuth2Token
     * @param Request $request
     * @return bool
     */
    public function readCharacter(OAuth2Token $OAuth2Token, Request $request): bool
    {
        return $this->read($request->user(), $OAuth2Token, $request);
    }

    /**
     * @param OAuth2Token $OAuth2Token
     * @param Request $request
     * @return bool
     */
    public function modifyCharacter(OAuth2Token $OAuth2Token, Request $request): bool
    {
        return false;
    }
}
