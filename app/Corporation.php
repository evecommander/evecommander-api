<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\BubblesNotifications;
use App\Traits\HasSRP;
use App\Traits\ReceivesInvoices;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

/**
 * Class Corporation
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
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany alliance
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany characters
 */
class Corporation extends Organization
{
    use HasSRP, ReceivesInvoices, BubblesNotifications;

    protected function getBubbleToModels(Notification $notification)
    {
        $notification;
    }

    protected $casts = [
        'settings' => 'array'
    ];

    /**
     * Get collection of all subscribers to invoice events on events that list this corporation as the recipient.
     *
     * @return Collection
     */
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
