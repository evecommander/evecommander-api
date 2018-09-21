<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface HasHandbooksContract.
 *
 * @property Collection handbooks
 */
interface HasHandbooksContract
{
    /**
     * Get relation between this model and any handbooks that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function handbooks();
}
