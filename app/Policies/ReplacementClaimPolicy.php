<?php

namespace App\Policies;

use App\User;
use App\ReplacementClaim;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplacementClaimPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the replacement claim.
     *
     * @param  \App\User  $user
     * @param  \App\ReplacementClaim  $replacementClaim
     * @return mixed
     */
    public function view(User $user, ReplacementClaim $replacementClaim)
    {
        //
    }

    /**
     * Determine whether the user can create replacement claims.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the replacement claim.
     *
     * @param  \App\User  $user
     * @param  \App\ReplacementClaim  $replacementClaim
     * @return mixed
     */
    public function update(User $user, ReplacementClaim $replacementClaim)
    {
        //
    }

    /**
     * Determine whether the user can delete the replacement claim.
     *
     * @param  \App\User  $user
     * @param  \App\ReplacementClaim  $replacementClaim
     * @return mixed
     */
    public function delete(User $user, ReplacementClaim $replacementClaim)
    {
        //
    }
}
