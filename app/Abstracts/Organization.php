<?php

namespace App\Abstracts;

use App\FleetType;
use App\Role;
use App\Subscription;
use App\Traits\BubblesNotifications;
use App\Traits\HasHandbooks;
use App\Traits\HasMembers;
use App\Traits\IsMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

/**
 * Class Organization.
 *
 * @property array settings
 * @property array mass_subscribables
 */
abstract class Organization extends Model
{
    use HasHandbooks, HasMembers, IsMember, BubblesNotifications;

    const MASS_SUBSCRIBABLE = [
        'fleet-comment'    => \App\Notifications\Fleet\CommentPosted::class,
        'fleet-created'    => \App\Notifications\Fleet\Created::class,
        'fleet-updated'    => \App\Notifications\Fleet\Updated::class,
        'handbook-created' => \App\Notifications\Handbook\Created::class,
        'handbook-updated' => \App\Notifications\Handbook\Updated::class,
        'handbook-comment' => \App\Notifications\Handbook\CommentPosted::class,
    ];

    /**
     * Get relation between this organization and any subscriptions that concern it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'organization');
    }

    /**
     * Get relation between this organization and any roles it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function roles()
    {
        return $this->morphMany(Role::class, 'owner');
    }

    /**
     * Get relation between this organization and any fleet types it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fleetTypes()
    {
        return $this->morphMany(FleetType::class, 'owner');
    }

    /**
     * Get mapping of all notifications that are subscribable for all members.
     *
     * @return array
     */
    public function getMassSubscribablesAttribute()
    {
        return self::MASS_SUBSCRIBABLE;
    }

    protected function getBubbleToModels(Notification $notification)
    {
        // get all subscriptions that have the notification's class enabled in it's 'settings' json column
        // @> is PostgreSQL containment operator
        // see https://www.postgresql.org/docs/10/static/datatype-json.html#JSON-CONTAINMENT
        /** @var \Illuminate\Database\Eloquent\Collection $subscriptions */
        $subscriptions = $this->subscriptions()->whereRaw('settings @> \'{"'.get_class($notification).'": 1}')
            ->with('character')->get();

        return $subscriptions->map(function (Subscription $subscription) {
            return $subscription->character;
        });
    }
}
