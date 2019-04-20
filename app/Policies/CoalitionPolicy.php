<?php

namespace App\Policies;

use App\Coalition;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesDefaultMembershipLevelRelation;
use App\Policies\Traits\AuthorizesNotificationsRelation;
use App\Policies\Traits\AuthorizesReceivedInvoicesRelation;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CoalitionPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization,
        AuthorizesRelations,
        AuthorizesDefaultMembershipLevelRelation,
        AuthorizesReceivedInvoicesRelation,
        AuthorizesNotificationsRelation;

    /**
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the coalition.
     *
     * @param User  $user
     * @param Model $coalition
     *
     * @return bool
     */
    public function read(User $user, Model $coalition): bool
    {
        // check if any characters are members of the alliance
        return $user->characters()->whereHas('corporation.alliance.coalition', function (Builder $builder) use ($coalition) {
            $builder->where('id', $coalition->id);
        })->exists();
    }

    /**
     * Determine whether the user can create coalitions.
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
     * Determine whether the user can update the coalition.
     *
     * @param User  $user
     * @param Model $coalition
     *
     * @return bool
     */
    public function update(User $user, Model $coalition): bool
    {
        return $user->hasCharacterWithPermission($coalition, 'organization', 'modify');
    }

    /**
     * Determine whether the user can delete the coalition.
     *
     * @param User  $user
     * @param Model $coalition
     *
     * @return bool
     */
    public function delete(User $user, Model $coalition): bool
    {
        return $user->hasCharacterWithPermission($coalition, 'organization', 'delete');
    }

    /**
     * Determine whether the user can view the alliances relation.
     *
     * @param User      $user
     * @param Coalition $coalition
     *
     * @return bool
     */
    public function readAlliances(User $user, Coalition $coalition): bool
    {
        return $this->readRelationship($user, $coalition, 'memberships');
    }

    /**
     * Determine whether the user can modify the alliances relation.
     *
     * @param User      $user
     * @param Coalition $coalition
     *
     * @return bool
     */
    public function modifyAlliances(User $user, Coalition $coalition): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the coalition relation.
     *
     * @param User      $user
     * @param Coalition $coalition
     *
     * @return bool
     */
    public function readCoalition(User $user, Coalition $coalition): bool
    {
        return $this->readRelationship($user, $coalition, 'member_of');
    }

    /**
     * Determine whether the user can modify the coalition relation.
     *
     * @param User      $user
     * @param Coalition $coalition
     *
     * @return bool
     */
    public function modifyCoalition(User $user, Coalition $coalition): bool
    {
        return false;
    }
}
