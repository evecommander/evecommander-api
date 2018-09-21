<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface HasRolesContract
 *
 * @property Collection roles
 */
interface HasRolesContract
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function roles();
}