<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasSRP;
use App\Traits\IssuesInvoices;
use App\Traits\ReceivesInvoices;
use App\Traits\UuidTrait;
use Illuminate\Support\Carbon;

/**
 * Class Coalition.
 *
 * @property string id
 * @property int leader_character_id
 * @property string name
 * @property string description
 * @property string logo
 * @property string default_membership_level
 * @property array settings
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection handbooks
 * @property \Illuminate\Database\Eloquent\Collection members
 * @property MembershipLevel defaultMembershipLevel
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
 * @property Character leader
 * @property \Illuminate\Database\Eloquent\Collection alliances
 * @property \Illuminate\Database\Eloquent\Collection roles
 */
class Coalition extends Organization
{
    use UuidTrait, HasSRP, ReceivesInvoices, IssuesInvoices;

    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get relation between this coalition and the character that is designated as the leader.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(Character::class, 'leader_character_id');
    }

    /**
     * Get relation between this coalition and any alliances that are members of it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function alliances()
    {
        return $this->members()->where('member_type', Alliance::class)->with('member');
    }
}
