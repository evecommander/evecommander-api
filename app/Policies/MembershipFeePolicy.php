<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\MembershipFee;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MembershipFeePolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the membership fee.
     *
     * @param User    $user
     * @param Model   $membershipFee
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $membershipFee, Request $request): bool
    {
        /* @var MembershipFee $membershipFee */
        return $this->authorizeRelation($membershipFee->organization, 'membership_fees', 'read', $request);
    }

    /**
     * Determine whether the user can create membership fees.
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        // this is run before validation so reject bad requests
        if (!$request->has('organization_type') || !$request->has('organization_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('organization_type')::find($request->get('organization_id'));

        return $this->authorizeRelation($organization, 'membership_fees', 'modify', $request);
    }

    /**
     * Determine whether the user can update the membership fee.
     *
     * @param User    $user
     * @param Model   $membershipFee
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $membershipFee, Request $request): bool
    {
        /* @var MembershipFee $membershipFee */
        return $this->authorizeRelation($membershipFee->organization, 'membership_fees', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the membership fee.
     *
     * @param User    $user
     * @param Model   $membershipFee
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $membershipFee, Request $request): bool
    {
        /* @var MembershipFee $membershipFee */
        return $this->authorizeRelation($membershipFee->organization, 'membership_fees', 'modify', $request);
    }

    /**
     * @param MembershipFee $membershipFee
     * @param Request       $request
     *
     * @return bool
     */
    public function readOrganization(MembershipFee $membershipFee, Request $request): bool
    {
        return $request->user()->can('read', [$membershipFee->organization, $request]);
    }

    /**
     * @param MembershipFee $membershipFee
     * @param Request       $request
     *
     * @return bool
     */
    public function modifyOrganization(MembershipFee $membershipFee, Request $request): bool
    {
        return false;
    }

    /**
     * @param MembershipFee $membershipFee
     * @param Request       $request
     *
     * @return bool
     */
    public function readBillingConditions(MembershipFee $membershipFee, Request $request): bool
    {
        return $request->user()->can('read', [$membershipFee->organization, $request]);
    }

    /**
     * @param MembershipFee $membershipFee
     * @param Request       $request
     *
     * @return bool
     */
    public function modifyBillingConditions(MembershipFee $membershipFee, Request $request): bool
    {
        return false;
    }
}
