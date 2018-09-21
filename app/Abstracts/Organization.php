<?php

namespace App\Abstracts;

use App\Contracts\HasFleetTypesContract;
use App\Contracts\HasHandbooksContract;
use App\Contracts\HasMembersContract;
use App\Contracts\HasNotificationsContract;
use App\Contracts\HasRolesContract;
use App\Contracts\HasSRPContract;
use App\Contracts\HasSubscriptionsContract;
use App\Contracts\IsMemberContract;
use App\Contracts\IssuesInvoicesContract;
use App\Contracts\ReceivesInvoicesContract;
use App\FleetType;
use App\Role;
use App\Subscription;
use App\Traits\HasHandbooks;
use App\Traits\HasMembers;
use App\Traits\HasSRP;
use App\Traits\IsMember;
use App\Traits\IssuesInvoices;
use App\Traits\ReceivesInvoices;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Organization.
 *
 * @property string name
 * @property array settings
 */
abstract class Organization extends Model implements
    HasHandbooksContract,
    HasMembersContract,
    HasNotificationsContract,
    IssuesInvoicesContract,
    ReceivesInvoicesContract,
    HasSRPContract,
    IsMemberContract,
    HasRolesContract,
    HasSubscriptionsContract,
    HasFleetTypesContract
{
    use UuidTrait, HasSRP, IssuesInvoices, ReceivesInvoices, Notifiable, HasHandbooks, HasMembers, IsMember;

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
