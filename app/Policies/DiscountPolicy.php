<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\Discount;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DiscountPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the discount.
     *
     * @param  User    $user
     * @param  Model   $discount
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $discount, Request $request): bool
    {
        /** @var Discount $discount */
        return $this->authorizeRelation($discount->organization, 'discounts', 'read', $request);
    }

    /**
     * Determine whether the user can create discounts.
     *
     * @param  User    $user
     * @param  string  $type
     * @param  Request $request
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

        return $this->authorizeRelation($organization, 'discounts', 'modify', $request);
    }

    /**
     * Determine whether the user can update the discount.
     *
     * @param  User    $user
     * @param  Model   $discount
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $discount, Request $request): bool
    {
        /** @var Discount $discount */
        return $this->authorizeRelation($discount->organization, 'discounts', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the discount.
     *
     * @param  User    $user
     * @param  Model   $discount
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $discount, Request $request): bool
    {
        /** @var Discount $discount */
        return $this->authorizeRelation($discount->organization, 'discounts', 'modify', $request);
    }

    /**
     * @param Discount $discount
     * @param Request $request
     * @return bool
     */
    public function readOrganization(Discount $discount, Request $request): bool
    {
        return $request->user()->can('read', [$discount->organization, $request]);
    }

    /**
     * @param Discount $discount
     * @param Request $request
     * @return bool
     */
    public function modifyOrganization(Discount $discount, Request $request): bool
    {
        return false;
    }

    /**
     * @param Discount $discount
     * @param Request $request
     * @return bool
     */
    public function readBillingCondition(Discount $discount, Request $request): bool
    {
        return $request->user()->can('read', [$discount->billingCondition, $request]);
    }

    /**
     * @param Discount $discount
     * @param Request $request
     * @return bool
     */
    public function modifyBillingCondition(Discount $discount, Request $request): bool
    {
        return $this->update($request->user(), $discount, $request);
    }
}
