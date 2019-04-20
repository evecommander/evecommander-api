<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\MembershipFee;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class MembershipFeePolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the membership fee.
     *
     * @param User  $user
     * @param Model $membershipFee
     *
     * @return bool
     */
    public function read(User $user, Model $membershipFee): bool
    {
        /* @var MembershipFee $membershipFee */
        return $this->readRelationship($user, $membershipFee->organization, 'membership_fees');
    }

    /**
     * Determine whether the user can create membership fees.
     *
     * @param User   $user
     * @param string $type
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

        return $this->modifyRelationship($user, $organization, 'membership_fees');
    }

    /**
     * Determine whether the user can update the membership fee.
     *
     * @param User  $user
     * @param Model $membershipFee
     *
     * @return bool
     */
    public function update(User $user, Model $membershipFee): bool
    {
        /* @var MembershipFee $membershipFee */
        return $this->modifyRelationship($user, $membershipFee->organization, 'membership_fees');
    }

    /**
     * Determine whether the user can delete the membership fee.
     *
     * @param User  $user
     * @param Model $membershipFee
     *
     * @return bool
     */
    public function delete(User $user, Model $membershipFee): bool
    {
        /* @var MembershipFee $membershipFee */
        return $this->modifyRelationship($user, $membershipFee->organization, 'membership_fees');
    }

    /**
     * @param User          $user
     * @param MembershipFee $membershipFee
     *
     * @return bool
     */
    public function readOrganization(User $user, MembershipFee $membershipFee): bool
    {
        return $user->can('read', [$membershipFee->organization]);
    }

    /**
     * @param User          $user
     * @param MembershipFee $membershipFee
     *
     * @return bool
     */
    public function modifyOrganization(User $user, MembershipFee $membershipFee): bool
    {
        return false;
    }

    /**
     * @param User          $user
     * @param MembershipFee $membershipFee
     *
     * @return bool
     */
    public function readBillingConditions(User $user, MembershipFee $membershipFee): bool
    {
        return $user->can('read', [$membershipFee->organization]);
    }

    /**
     * @param User          $user
     * @param MembershipFee $membershipFee
     *
     * @return bool
     */
    public function modifyBillingConditions(User $user, MembershipFee $membershipFee): bool
    {
        return false;
    }
}
