<?php

namespace App\Policies;

use App\User;
use App\Doctrine;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctrinePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the doctrine.
     *
     * @param  \App\User  $user
     * @param  \App\Doctrine  $doctrine
     * @return mixed
     */
    public function view(User $user, Doctrine $doctrine)
    {
        //
    }

    /**
     * Determine whether the user can create doctrines.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the doctrine.
     *
     * @param  \App\User  $user
     * @param  \App\Doctrine  $doctrine
     * @return mixed
     */
    public function update(User $user, Doctrine $doctrine)
    {
        //
    }

    /**
     * Determine whether the user can delete the doctrine.
     *
     * @param  \App\User  $user
     * @param  \App\Doctrine  $doctrine
     * @return mixed
     */
    public function delete(User $user, Doctrine $doctrine)
    {
        //
    }
}
