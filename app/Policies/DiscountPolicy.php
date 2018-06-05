<?php

namespace App\Policies;

use App\User;
use App\Discount;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the discount.
     *
     * @param  \App\User  $user
     * @param  \App\Discount  $discount
     * @return mixed
     */
    public function view(User $user, Discount $discount)
    {
        //
    }

    /**
     * Determine whether the user can create discounts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the discount.
     *
     * @param  \App\User  $user
     * @param  \App\Discount  $discount
     * @return mixed
     */
    public function update(User $user, Discount $discount)
    {
        //
    }

    /**
     * Determine whether the user can delete the discount.
     *
     * @param  \App\User  $user
     * @param  \App\Discount  $discount
     * @return mixed
     */
    public function delete(User $user, Discount $discount)
    {
        //
    }
}
