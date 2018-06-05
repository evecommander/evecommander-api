<?php

namespace App\Policies;

use App\User;
use App\MembershipFee;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembershipFeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the membership fee.
     *
     * @param  \App\User  $user
     * @param  \App\MembershipFee  $membershipFee
     * @return mixed
     */
    public function view(User $user, MembershipFee $membershipFee)
    {
        //
    }

    /**
     * Determine whether the user can create membership fees.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the membership fee.
     *
     * @param  \App\User  $user
     * @param  \App\MembershipFee  $membershipFee
     * @return mixed
     */
    public function update(User $user, MembershipFee $membershipFee)
    {
        //
    }

    /**
     * Determine whether the user can delete the membership fee.
     *
     * @param  \App\User  $user
     * @param  \App\MembershipFee  $membershipFee
     * @return mixed
     */
    public function delete(User $user, MembershipFee $membershipFee)
    {
        //
    }
}
