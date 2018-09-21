<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface HasSubscriptionsContract.
 *
 * @property Collection subscriptions
 */
interface HasSubscriptionsContract
{
    /**
     * Get relation between this model and any subscriptions that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function subscriptions();
}
