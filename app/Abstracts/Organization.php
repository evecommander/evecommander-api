<?php

namespace App\Abstracts;

use App\BillingCondition;
use App\BillingConditionGroup;
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
use App\Discount;
use App\Fleet;
use App\FleetType;
use App\MembershipLevel;
use App\Role;
use App\Subscription;
use App\Traits\HasHandbooks;
use App\Traits\HasMembers;
use App\Traits\HasSRP;
use App\Traits\IsMember;
use App\Traits\IssuesInvoices;
use App\Traits\ReceivesInvoices;
use App\Traits\UuidTrait;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Organization.
 *
 * @property string name
 * @property array settings
 * @property CarbonInterval dueDateInterval
 * @property CarbonInterval hardDueDateInterval
 *
 * Relationships
 * @property MembershipLevel defaultMembershipLevel
 * @property \Illuminate\Database\Eloquent\Collection handbooks
 * @property \Illuminate\Database\Eloquent\Collection members
 * @property \Illuminate\Database\Eloquent\Collection membershipLevels
 * @property \Illuminate\Database\Eloquent\Collection memberships
 * @property \Illuminate\Database\Eloquent\Collection replacementClaims
 * @property \Illuminate\Database\Eloquent\Collection issuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection fulfilledIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection overdueIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection pendingIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection defaultIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection receivedIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection fulfilledReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection overdueReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection pendingReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection defaultReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection notifications
 * @property \Illuminate\Database\Eloquent\Collection readNotifications
 * @property \Illuminate\Database\Eloquent\Collection unreadNotifications
 * @property \Illuminate\Database\Eloquent\Collection fleets
 * @property \Illuminate\Database\Eloquent\Collection fleetTypes
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection discounts
 * @property \Illuminate\Database\Eloquent\Collection billingConditions
 * @property \Illuminate\Database\Eloquent\Collection billingConditionGroups
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

    public function getDueDateIntervalAttribute()
    {
        return isset($this->settings['due_date_interval']) ?
            CarbonInterval::fromString($this->settings['due_date_interval']) :
            CarbonInterval::create(0, 0, 2);
    }

    public function getHardDueDateIntervalAttribute()
    {
        return isset($this->settings['hard_due_date_interval']) ?
            CarbonInterval::fromString($this->settings['hard_due_date_interval']) :
            CarbonInterval::create(0, 0, 2);
    }

    /**
     * Get relation between this organization and any billing conditions it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function billingConditions()
    {
        return $this->morphMany(BillingCondition::class, 'organization');
    }

    /**
     * Get relation between this organization and any billing condition groups it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function billingConditionGroups()
    {
        return $this->morphMany(BillingConditionGroup::class, 'organization');
    }

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

    /**
     * Get relation between this organization and any fleets it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fleets()
    {
        return $this->morphMany(Fleet::class, 'organization');
    }

    /**
     * Get relation between this organization and any discounts it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function discounts()
    {
        return $this->morphMany(Discount::class, 'organization');
    }
}
