<?php

namespace App\Policies;

use App\Character;
use App\Corporation;
use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesDefaultMembershipLevelRelation;
use App\Policies\Traits\AuthorizesInvoicesRelation;
use App\Policies\Traits\AuthorizesMembershipsRelation;
use App\Policies\Traits\AuthorizesNotificationsRelation;
use App\Policies\Traits\AuthorizesReceivedInvoicesRelation;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CorporationPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization,
        AuthorizesRelations,
        AuthorizesDefaultMembershipLevelRelation,
        AuthorizesReceivedInvoicesRelation,
        AuthorizesInvoicesRelation,
        AuthorizesNotificationsRelation,
        AuthorizesMembershipsRelation;

    /**
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the alliance.
     *
     * @param User    $user
     * @param Model   $corporation
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $corporation, Request $request): bool
    {
        // check if any characters are members of the alliance
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER))->load('corporation');

        /* @var Corporation $corporation */
        return $character->corporation->id === $corporation->id;
    }

    /**
     * Determine whether the user can create alliances.
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the alliance.
     *
     * @param User    $user
     * @param Model   $corporation
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $corporation, Request $request): bool
    {
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        /* @var Corporation $corporation */
        return $character->hasPermission('update', $corporation);
    }

    /**
     * Determine whether the user can delete the alliance.
     *
     * @param User    $user
     * @param Model   $corporation
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $corporation, Request $request): bool
    {
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        /* @var Corporation $corporation */
        return $character->hasPermission('delete', $corporation);
    }

    /**
     * Determine whether the user can view the characters relation.
     *
     * @param Corporation $corporation
     * @param Request     $request
     *
     * @return bool
     */
    public function readCharacters(Corporation $corporation, Request $request): bool
    {
        return $this->authorizeRelation($corporation, 'memberships', 'read', $request);
    }

    /**
     * Determine whether the user can modify the characters relation.
     *
     * @param Corporation $corporation
     * @param Request     $request
     *
     * @return bool
     */
    public function modifyCharacters(Corporation $corporation, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the alliance relation.
     *
     * @param Corporation $corporation
     * @param Request     $request
     *
     * @return bool
     */
    public function readAlliance(Corporation $corporation, Request $request): bool
    {
        return $this->authorizeRelation($corporation, 'member_of', 'read', $request);
    }

    /**
     * Determine whether the user can modify the alliance relation.
     *
     * @param Corporation $corporation
     * @param Request     $request
     *
     * @return bool
     */
    public function modifyAlliance(Corporation $corporation, Request $request): bool
    {
        return false;
    }
}
