<?php

namespace App\Policies;

use App\Character;
use App\Corporation;
use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesDefaultMembershipLevelRelation;
use App\Policies\Traits\AuthorizesMembershipsRelation;
use App\Policies\Traits\AuthorizesNotificationsRelation;
use App\Policies\Traits\AuthorizesReceivedInvoicesRelation;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CorporationPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization,
        AuthorizesRelations,
        AuthorizesDefaultMembershipLevelRelation,
        AuthorizesReceivedInvoicesRelation,
        AuthorizesNotificationsRelation,
        AuthorizesMembershipsRelation;

    /**
     * @param User    $user
     * @param string  $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the corporation.
     *
     * @param User    $user
     * @param Model   $corporation
     *
     * @return bool
     */
    public function read(User $user, Model $corporation): bool
    {
        // check if any characters are members of the corporation
        return $user->characters()->whereHas('corporation', function (Builder $builder) use ($corporation) {
            $builder->where('id', $corporation->id);
        })->exists();
    }

    /**
     * Determine whether the user can create corporations.
     *
     * @param User    $user
     * @param string  $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the corporation.
     *
     * @param User    $user
     * @param Model   $corporation
     *
     * @return bool
     */
    public function update(User $user, Model $corporation): bool
    {
        return $user->hasCharacterWithPermission($corporation, 'organization', 'modify');
    }

    /**
     * Determine whether the user can delete the alliance.
     *
     * @param User    $user
     * @param Model   $corporation
     *
     * @return bool
     */
    public function delete(User $user, Model $corporation): bool
    {
        return $user->hasCharacterWithPermission($corporation, 'organization', 'delete');
    }

    /**
     * Determine whether the user can view the characters relation.
     *
     * @param User        $user
     * @param Corporation $corporation
     *
     * @return bool
     */
    public function readCharacters(User $user, Corporation $corporation): bool
    {
        return $this->readRelationship($user, $corporation, 'memberships');
    }

    /**
     * Determine whether the user can modify the characters relation.
     *
     * @param User        $user
     * @param Corporation $corporation
     *
     * @return bool
     */
    public function modifyCharacters(User $user, Corporation $corporation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the alliance relation.
     *
     * @param User        $user
     * @param Corporation $corporation
     *
     * @return bool
     */
    public function readAlliance(User $user, Corporation $corporation): bool
    {
        return $this->readRelationship($user, $corporation, 'member_of');
    }

    /**
     * Determine whether the user can modify the alliance relation.
     *
     * @param User        $user
     * @param Corporation $corporation
     *
     * @return bool
     */
    public function modifyAlliance(User $user, Corporation $corporation): bool
    {
        return false;
    }
}
