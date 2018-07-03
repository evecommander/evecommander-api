<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\BillingCondition;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BillingConditionPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the billing condition.
     *
     * @param  User    $user
     * @param  Model   $condition
     * @param  Request $request
     * @return boolean
     */
    public function read(User $user, Model $condition, Request $request): bool
    {
        /** @var BillingCondition $condition */
        return $this->authorizeRelation($condition->organization, 'billing_condition', 'read', $request);
    }

    /**
     * Determine whether the user can create billing conditions.
     *
     * @param  User    $user
     * @param  string  $type
     * @param  Request $request
     * @return boolean
     */
    public function create(User $user, string $type, Request $request): bool
    {
        // this is run before validation so reject bad requests
        if (!$request->has('organization_type') || !$request->has('organization_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('organization_type')::find($request->get('organization_id'));

        return $this->authorizeRelation($organization, 'billing_condition', 'modify', $request);
    }

    /**
     * Determine whether the user can update the billing condition.
     *
     * @param  User    $user
     * @param  Model   $condition
     * @param  Request $request
     * @return boolean
     */
    public function update(User $user, Model $condition, Request $request): bool
    {
        /** @var BillingCondition $condition */
        return $this->authorizeRelation($condition->organization, 'billing_condition', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the billing condition.
     *
     * @param  User    $user
     * @param  Model   $condition
     * @param  Request $request
     * @return boolean
     */
    public function delete(User $user, Model $condition, Request $request): bool
    {
        /** @var BillingCondition $condition */
        return $this->authorizeRelation($condition->organization, 'billing_condition', 'modify', $request);
    }

    /**
     * Determine whether the user can read the relationship.
     *
     * @param  User    $user
     * @param  Model   $condition
     * @param  string  $field
     * @param  Request $request
     * @return boolean
     */
    public function readRelationship(User $user, Model $condition, string $field, Request $request): bool
    {
        /** @var BillingCondition $condition */
        return $this->authorizeRelation($condition->organization, $field, 'read', $request);
    }

    /**
     * Determine whether the user can modify the relationship.
     *
     * @param  User    $user
     * @param  Model   $condition
     * @param  string  $field
     * @param  Request $request
     * @return boolean
     */
    public function modifyRelationship(User $user, Model $condition, string $field, Request $request): bool
    {
        /** @var BillingCondition $condition */
        return $this->authorizeRelation($condition->organization, $field, 'modify', $request);
    }

    /**
     * Determine whether the user can read the organization relation.
     *
     * @return bool
     */
    public function readOrganization(Organization $organization, Request $request)
    {
        return true;
    }

    /**
     * Determine whether the user can modify the organization relation.
     *
     * @return bool
     */
    public function modifyOrganization(Organization $organization, Request $request)
    {
        return false;
    }

    /**
     * Determine whether the user can read the discounts relation.
     *
     * @param Organization $organization
     * @param Request      $request
     * @return bool
     */
    public function readDiscounts(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'billing_condition', 'read', $request);
    }

    /**
     * Determine whether the user can modify the discounts relation.
     *
     * @param Organization $organization
     * @param Request      $request
     * @return bool
     */
    public function modifyDiscounts(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'billing_condition', 'modify', $request);
    }

    /**
     * Determine whether the user can read the membership fees relation.
     *
     * @param Organization $organization
     * @param Request      $request
     * @return bool
     */
    public function readMembershipFees(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'billing_condition', 'read', $request);
    }

    /**
     * Determine whether the user can modify the membership fees relation.
     *
     * @param Organization $organization
     * @param Request      $request
     * @return bool
     */
    public function modifyMembershipFees(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'billing_condition', 'modify', $request);
    }
}
