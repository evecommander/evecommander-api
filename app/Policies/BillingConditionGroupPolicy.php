<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class BillingConditionGroupPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the billing condition group.
     *
     * @param User  $user
     * @param Model $conditionGroup
     *
     * @return bool
     */
    public function read(User $user, Model $conditionGroup): bool
    {
        return $user->can('read', $conditionGroup);
    }

    /**
     * Determine whether the user can create billing conditions.
     *
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        return $user->can('create', $type);
    }

    /**
     * Determine whether the user can update the billing condition.
     *
     * @param User  $user
     * @param Model $conditionGroup
     *
     * @return bool
     */
    public function update(User $user, Model $conditionGroup): bool
    {
        return $user->can('update', $conditionGroup);
    }

    /**
     * Determine whether the user can delete the billing condition.
     *
     * @param User  $user
     * @param Model $conditionGroup
     *
     * @return bool
     */
    public function delete(User $user, Model $conditionGroup): bool
    {
        return $user->can('delete', $conditionGroup);
    }

    /**
     * Determine whether the user can read the organization relation.
     *
     * @param User         $user
     * @param Organization $organization
     *
     * @return bool
     */
    public function readOrganization(User $user, Organization $organization)
    {
        return true;
    }

    /**
     * Determine whether the user can modify the organization relation.
     *
     * @param User         $user
     * @param Organization $organization
     *
     * @return bool
     */
    public function modifyOrganization(User $user, Organization $organization)
    {
        return false;
    }

    /**
     * Determine whether the user can read the discounts relation.
     *
     * @param User         $user
     * @param Organization $organization
     *
     * @return bool
     */
    public function readDiscounts(User $user, Organization $organization)
    {
        return $this->readRelationship($user, $organization, 'billing_condition');
    }

    /**
     * Determine whether the user can modify the discounts relation.
     *
     * @param User         $user
     * @param Organization $organization
     *
     * @return bool
     */
    public function modifyDiscounts(User $user, Organization $organization)
    {
        return $this->modifyRelationship($user, $organization, 'billing_condition');
    }

    /**
     * Determine whether the user can read the membership fees relation.
     *
     * @param User         $user
     * @param Organization $organization
     *
     * @return bool
     */
    public function readMembershipFees(User $user, Organization $organization)
    {
        return $this->readRelationship($user, $organization, 'billing_condition');
    }

    /**
     * Determine whether the user can modify the membership fees relation.
     *
     * @param User         $user
     * @param Organization $organization
     *
     * @return bool
     */
    public function modifyMembershipFees(User $user, Organization $organization)
    {
        return $this->modifyRelationship($user, $organization, 'billing_condition');
    }
}
