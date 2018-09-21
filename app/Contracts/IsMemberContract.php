<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface IsMemberContract
 *
 * @property Collection memberships
 */
interface IsMemberContract
{
    /**
     * Get relation between this model and any memberships that it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function memberships();
}