<?php

namespace App\Policies;

use App\Alliance;
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

class AlliancePolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the alliance.
     *
     * @param User    $user
     * @param Model   $alliance
     *
     * @return bool
     */
    public function read(User $user, Model $alliance): bool
    {
        // check if any characters are members of the alliance
        return $user->characters()->whereHas('corporation.alliance', function (Builder $builder) use ($alliance) {
            $builder->where('id', $alliance->id);
        })->exists();
    }

    /**
     * Determine whether the user can create alliances.
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
     * Determine whether the user can update the alliance.
     *
     * @param User    $user
     * @param Model   $alliance
     *
     * @return bool
     */
    public function update(User $user, Model $alliance): bool
    {
        return $user->hasCharacterWithPermission($alliance, 'organization', 'modify');
    }

    /**
     * Determine whether the user can delete the alliance.
     *
     * @param User    $user
     * @param Model   $alliance
     *
     * @return bool
     */
    public function delete(User $user, Model $alliance): bool
    {
        return $user->hasCharacterWithPermission($alliance, 'organization', 'delete');
    }

    /**
     * Determine whether the user can view the corporations relation.
     *
     * @param User     $user
     * @param Alliance $alliance
     *
     * @return bool
     */
    public function readCorporations(User $user, Alliance $alliance): bool
    {
        return $user->hasCharacterWithPermission($alliance, 'memberships', 'read');
    }

    /**
     * Determine whether the user can modify the corporations relation.
     *
     * @param User     $user
     * @param Alliance $alliance
     *
     * @return bool
     */
    public function modifyCorporations(User $user, Alliance $alliance): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the coalition relation.
     *
     * @param User     $user
     * @param Alliance $alliance
     *
     * @return bool
     */
    public function readCoalition(User $user, Alliance $alliance): bool
    {
        return $this->authorizeRelation($user, $alliance, 'member_of', 'read');
    }

    /**
     * Determine whether the user can modify the coalition relation.
     *
     * @param User     $user
     * @param Alliance $alliance
     *
     * @return bool
     */
    public function modifyCoalition(User $user, Alliance $alliance): bool
    {
        return false;
    }
}
