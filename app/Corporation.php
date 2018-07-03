<?php

namespace App;

use App\Abstracts\Organization;
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
 * @property \Illuminate\Database\Eloquent\Collection replacementClaims
 * @property \Illuminate\Database\Eloquent\Collection invoices
 * @property \Illuminate\Database\Eloquent\Collection fulfilledInvoices
 * @property \Illuminate\Database\Eloquent\Collection overdueInvoices
 * @property \Illuminate\Database\Eloquent\Collection pendingInvoices
 * @property \Illuminate\Database\Eloquent\Collection defaultInvoices
 * @property \Illuminate\Database\Eloquent\Collection receivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection fulfilledReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection overdueReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection pendingReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection defaultReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection notifications
 * @property \Illuminate\Database\Eloquent\Collection readNotifications
 * @property \Illuminate\Database\Eloquent\Collection unreadNotifications
 * @property Alliance alliance
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
        return $this->memberships()->where('organization_type', Alliance::class)->with('organization');
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
