<?php

namespace App\Policies;

use App\User;
use App\MembershipLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembershipLevelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the membership level.
     *
     * @param  \App\User  $user
     * @param  \App\MembershipLevel  $membershipLevel
     * @return mixed
     */
    public function view(User $user, MembershipLevel $membershipLevel)
    {
        //
    }

    /**
     * Determine whether the user can create membership levels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the membership level.
     *
     * @param  \App\User  $user
     * @param  \App\MembershipLevel  $membershipLevel
     * @return mixed
     */
    public function update(User $user, MembershipLevel $membershipLevel)
    {
        //
    }

    /**
     * Determine whether the user can delete the membership level.
     *
     * @param  \App\User  $user
     * @param  \App\MembershipLevel  $membershipLevel
     * @return mixed
     */
    public function delete(User $user, MembershipLevel $membershipLevel)
    {
        //
    }
}
