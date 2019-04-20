<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Discount;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class DiscountPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the discount.
     *
     * @param User  $user
     * @param Model $discount
     *
     * @return bool
     */
    public function read(User $user, Model $discount): bool
    {
        /* @var Discount $discount */
        return $this->readRelationship($user, $discount->organization, 'discounts', 'read');
    }

    /**
     * Determine whether the user can create discounts.
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

        return $this->modifyRelationship($user, $organization, 'discounts');
    }

    /**
     * Determine whether the user can update the discount.
     *
     * @param User  $user
     * @param Model $discount
     *
     * @return bool
     */
    public function update(User $user, Model $discount): bool
    {
        /* @var Discount $discount */
        return $this->modifyRelationship($user, $discount->organization, 'discounts');
    }

    /**
     * Determine whether the user can delete the discount.
     *
     * @param User  $user
     * @param Model $discount
     *
     * @return bool
     */
    public function delete(User $user, Model $discount): bool
    {
        /* @var Discount $discount */
        return $this->modifyRelationship($user, $discount->organization, 'discounts');
    }

    /**
     * @param User     $user
     * @param Discount $discount
     *
     * @return bool
     */
    public function readOrganization(User $user, Discount $discount): bool
    {
        return $user->can('read', [$discount->organization]);
    }

    /**
     * @param User     $user
     * @param Discount $discount
     *
     * @return bool
     */
    public function modifyOrganization(User $user, Discount $discount): bool
    {
        return false;
    }

    /**
     * @param User     $user
     * @param Discount $discount
     *
     * @return bool
     */
    public function readConditional(User $user, Discount $discount): bool
    {
        return $user->can('read', [$discount->conditional]);
    }

    /**
     * @param User     $user
     * @param Discount $discount
     *
     * @return bool
     */
    public function modifyConditional(User $user, Discount $discount): bool
    {
        return $this->update($user, $discount);
    }
}
