<?php

namespace App\Policies;

use App\User;
use App\BillingCondition;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillingConditionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the billing condition.
     *
     * @param  \App\User  $user
     * @param  \App\BillingCondition  $billingCondition
     * @return mixed
     */
    public function view(User $user, BillingCondition $billingCondition)
    {
        //
    }

    /**
     * Determine whether the user can create billing conditions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the billing condition.
     *
     * @param  \App\User  $user
     * @param  \App\BillingCondition  $billingCondition
     * @return mixed
     */
    public function update(User $user, BillingCondition $billingCondition)
    {
        //
    }

    /**
     * Determine whether the user can delete the billing condition.
     *
     * @param  \App\User  $user
     * @param  \App\BillingCondition  $billingCondition
     * @return mixed
     */
    public function delete(User $user, BillingCondition $billingCondition)
    {
        //
    }
}
