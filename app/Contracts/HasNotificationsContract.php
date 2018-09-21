<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface HasNotificationsContract.
 *
 * @property Collection notifications
 * @property Collection readNotifications
 * @property Collection unreadNotifications
 */
interface HasNotificationsContract
{
    /**
     * Get relation between this model and any notifications that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications();

    /**
     * Get relation between this model and any read notifications that it owns.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function readNotifications();

    /**
     * Get relation between this model and any unread notifications that it owns.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function unreadNotifications();
}
