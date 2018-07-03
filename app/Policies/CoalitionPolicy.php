<?php

namespace App\Policies;

use App\Character;
use App\Coalition;
use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesDefaultMembershipLevelRelation;
use App\Policies\Traits\AuthorizesInvoicesRelation;
use App\Policies\Traits\AuthorizesNotificationsRelation;
use App\Policies\Traits\AuthorizesReceivedInvoicesRelation;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CoalitionPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization,
        AuthorizesRelations,
        AuthorizesDefaultMembershipLevelRelation,
        AuthorizesReceivedInvoicesRelation,
        AuthorizesInvoicesRelation,
        AuthorizesNotificationsRelation;

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
     * Determine whether the user can view the coalition.
     *
     * @param User    $user
     * @param Model   $condition
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $condition, Request $request): bool
    {
        // check if character is a member of the alliance
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER))->load('corporation.alliance.coalition');

        /* @var Coalition $coalition */
        return $character->corporation->alliance->coalition->id === $coalition->id;
    }

    /**
     * Determine whether the user can create coalition.
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
     * Determine whether the user can update the coalition.
     *
     * @param User    $user
     * @param Model   $condition
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $condition, Request $request): bool
    {
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        /* @var Coalition $coalition */
        return $character->hasPermission('update', $coalition);
    }

    /**
     * Determine whether the user can delete the coalition.
     *
     * @param User    $user
     * @param Model   $condition
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $condition, Request $request): bool
    {
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        /* @var Coalition $coalition */
        return $character->hasPermission('delete', $coalition);
    }

    /**
     * Determine whether the user can view the alliances relation.
     *
     * @param Coalition $coalition
     * @param Request   $request
     *
     * @return bool
     */
    public function readAlliances(Coalition $coalition, Request $request): bool
    {
        return $this->authorizeRelation($coalition, 'memberships', 'read', $request);
    }

    /**
     * Determine whether the user can modify the alliances relation.
     *
     * @param Coalition $coalition
     * @param Request   $request
     *
     * @return bool
     */
    public function modifyAlliances(Coalition $coalition, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the coalition relation.
     *
     * @param Coalition $coalition
     * @param Request   $request
     *
     * @return bool
     */
    public function readCoalition(Coalition $coalition, Request $request): bool
    {
        return $this->authorizeRelation($coalition, 'member_of', 'read', $request);
    }

    /**
     * Determine whether the user can modify the coalition relation.
     *
     * @param Coalition $coalition
     * @param Request   $request
     *
     * @return bool
     */
    public function modifyCoalition(Coalition $coalition, Request $request): bool
    {
        return false;
    }
}
