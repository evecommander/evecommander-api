<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\BubblesNotifications;
use App\Traits\HasSRP;
use App\Traits\ReceivesInvoices;
use Illuminate\Support\Carbon;

/**
 * Class Corporation.
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
 * @property \Illuminate\Database\Eloquent\Collection alliance
 * @property \Illuminate\Database\Eloquent\Collection characters
 * @property \Illuminate\Database\Eloquent\Collection roles
 */
class Corporation extends Organization
{
    use HasSRP, ReceivesInvoices;

    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get relationship between this corporation and the alliance it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function alliance()
    {
        return $this->memberships()->where('owner_type', Alliance::class)->with('owner');
    }

    /**
     * Get relation between this corporation and any characters that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function characters()
    {
        return $this->members()->where('member_type', Character::class)->with('member');
    }
}
