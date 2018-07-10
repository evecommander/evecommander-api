<?php

namespace App\Abstracts;

use App\FleetType;
use App\Role;
use App\Subscription;
use App\Traits\HasHandbooks;
use App\Traits\HasMembers;
use App\Traits\IsMember;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Organization.
 *
 * @property string name
 * @property array settings
 * @property array mass_subscribables
 */
abstract class Organization extends Model
{
    use HasHandbooks, HasMembers, IsMember;

    const MASS_SUBSCRIBABLE = [
        'fleet-created',
        'handbook-created',
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
        return $this->morphMany(Role::class, 'organization');
    }

    /**
     * Get relation between this organization and any fleet types it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fleetTypes()
    {
        return $this->morphMany(FleetType::class, 'organization');
    }
}
