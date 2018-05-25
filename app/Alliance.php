<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasSRP;
use App\Traits\IssuesInvoices;
use App\Traits\ReceivesInvoices;
use App\Traits\UuidTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class Alliance.
 *
 * @property string id
 * @property int api_id
 * @property string name
 * @property string default_membership_level
 * @property array settings
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection handbooks
 * @property \Illuminate\Database\Eloquent\Collection members
 * @property \Illuminate\Database\Eloquent\Collection defaultMembershipLevel
 * @property \Illuminate\Database\Eloquent\Collection membershipLevels
 * @property \Illuminate\Database\Eloquent\Collection memberships
 * @property \Illuminate\Database\Eloquent\Collection claims
 * @property \Illuminate\Database\Eloquent\Collection invoices
 * @property \Illuminate\Database\Eloquent\Collection fulfilledInvoices
 * @property \Illuminate\Database\Eloquent\Collection overdueInvoices
 * @property \Illuminate\Database\Eloquent\Collection pendingInvoices
 * @property \Illuminate\Database\Eloquent\Collection defaultInvoices
 * @property \Illuminate\Database\Eloquent\Collection issuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection fulfilledIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection overdueIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection pendingIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection defaultIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Collection notifications
 * @property \Illuminate\Database\Eloquent\Collection readNotifications
 * @property \Illuminate\Database\Eloquent\Collection unreadNotifications
 * @property \Illuminate\Database\Eloquent\Collection coalition
 * @property \Illuminate\Database\Eloquent\Collection roles
 */
class Alliance extends Organization
{
    use UuidTrait, HasSRP, ReceivesInvoices, IssuesInvoices, Notifiable;

    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get relation between this alliance and the coalition it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function coalition()
    {
        return $this->memberships()->where('organization_type', Coalition::class)->with('organization');
    }

    /**
     * Get relation between this alliance and any corporations that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function corporations()
    {
        return $this->members()->where('member_type', Corporation::class)->with('member');
    }
}
