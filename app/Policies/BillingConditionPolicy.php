<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\BillingCondition;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class BillingConditionPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User    $user
     * @param string  $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the billing condition.
     *
     * @param User    $user
     * @param Model   $condition
     *
     * @return bool
     */
    public function read(User $user, Model $condition): bool
    {
        /* @var BillingCondition $condition */
        return $this->readRelationship($user, $condition->organization, 'billing_condition');
    }

    /**
     * Determine whether the user can create billing conditions.
     *
     * @param User    $user
     * @param string  $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        $request = \request();

        // this is run before validation so reject bad requests
        if (!$request->has('organization_type') || !$request->has('organization_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('organization_type')::find($request->get('organization_id'));

        return $this->modifyRelationship($user, $organization, 'billing_condition');
    }

    /**
     * Determine whether the user can update the billing condition.
     *
     * @param User    $user
     * @param Model   $condition
     *
     * @return bool
     */
    public function update(User $user, Model $condition): bool
    {
        /* @var BillingCondition $condition */
        return $this->modifyRelationship($user, $condition->organization, 'billing_condition');
    }

    /**
     * Determine whether the user can delete the billing condition.
     *
     * @param User    $user
     * @param Model   $condition
     *
     * @return bool
     */
    public function delete(User $user, Model $condition): bool
    {
        /* @var BillingCondition $condition */
        return $this->modifyRelationship($user, $condition->organization, 'billing_condition');
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
