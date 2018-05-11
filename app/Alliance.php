<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasSettings;
use App\Traits\HasSRP;
use App\Traits\IssuesInvoices;
use App\Traits\ReceivesInvoices;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class Alliance
 *
 * @property string id
 * @property int api_id
 * @property string name
 * @property int default_membership_level
 * @property array settings
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Alliance extends Organization
{
    use HasSRP, ReceivesInvoices, IssuesInvoices, Notifiable;

    /**
     * Get collection of subscribers for invoice events
     *
     * @return \Illuminate\Support\Collection
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

    public function coalition()
    {
        $coalitionMembership = $this->memberships()->where('owner_type', Coalition::class)
            ->with('owner')->first();
        return $coalitionMembership->owner();
    }
}
