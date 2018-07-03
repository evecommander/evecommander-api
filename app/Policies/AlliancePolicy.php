<?php

namespace App\Policies;

use App\Alliance;
use App\Character;
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

class AlliancePolicy implements ResourcePolicyInterface
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
     * @param Model   $alliance
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $alliance, Request $request): bool
    {
        // check if any characters are members of the alliance
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER))->load('corporation.alliance');

        /* @var Alliance $alliance */
        return $character->corporation->alliance->id === $alliance->id;
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
     * @param Model   $alliance
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $alliance, Request $request): bool
    {
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        /* @var Alliance $alliance */
        return $character->hasPermission('organization_modify', $alliance);
    }

    /**
     * Determine whether the user can delete the alliance.
     *
     * @param User    $user
     * @param Model   $alliance
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $alliance, Request $request): bool
    {
        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        /* @var Alliance $alliance */
        return $character->hasPermission('organization_delete', $alliance);
    }

    /**
     * Determine whether the user can view the corporations relation.
     *
     * @param Alliance $alliance
     * @param Request  $request
     *
     * @return bool
     */
    public function readCorporations(Alliance $alliance, Request $request): bool
    {
        return $this->authorizeRelation($alliance, 'memberships', 'read', $request);
    }

    /**
     * Determine whether the user can modify the corporations relation.
     *
     * @param Alliance $alliance
     * @param Request  $request
     *
     * @return bool
     */
    public function modifyCorporations(Alliance $alliance, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the coalition relation.
     *
     * @param Alliance $alliance
     * @param Request  $request
     *
     * @return bool
     */
    public function readCoalition(Alliance $alliance, Request $request): bool
    {
        return $this->authorizeRelation($alliance, 'member_of', 'read', $request);
    }

    /**
     * Determine whether the user can modify the coalition relation.
     *
     * @param Alliance $alliance
     * @param Request  $request
     *
     * @return bool
     */
    public function modifyCoalition(Alliance $alliance, Request $request): bool
    {
        return false;
    }
}
