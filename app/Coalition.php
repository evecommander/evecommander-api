<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasSRP;
use App\Traits\IssuesInvoices;
use App\Traits\ReceivesInvoices;
use App\Traits\UuidTrait;
use Illuminate\Support\Carbon;

/**
 * Class Coalition
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
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany handbooks
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany members
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo defaultMembershipLevel
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany membershipLevels
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany memberships
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany claims
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany invoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany fulfilledInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany overdueInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany pendingInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany defaultInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany issuedInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany fulfilledIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany overdueIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany pendingIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany defaultIssuedInvoices
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany notifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany readNotifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany unreadNotifications
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo leader
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany alliances
 */
class Coalition extends Organization
{
    use UuidTrait, HasSRP, ReceivesInvoices, IssuesInvoices;

    protected $casts = [
        'settings' => 'array'
    ];

    public function receivedInvoiceSubscribers()
    {
        $subscriberIds = $this->settings['invoices']['received']['subscribers'];

        $subscribers = User::find($subscriberIds);

        // normalize single result case
        if ($subscribers instanceof User) {
            $subscribers = collect($subscribers);
        }

        return $subscribers;
    }

    /**
     * Get relation between this coalition and the character that is designated as the leader
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(Character::class, 'leader_character_id');
    }

    /**
     * Get relation between this coalition and any alliances that are members of it
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function alliances()
    {
        return $this->members()->where('member_type', Alliance::class)->with('member');
    }
}
