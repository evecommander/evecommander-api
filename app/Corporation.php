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
 */
class Corporation extends Organization
{
    use HasSRP, ReceivesInvoices, BubblesNotifications;

    protected function getBubbleToModels(Notification $notification)
    {
        $notification;
    }

    /**
     * Get collection of all
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

    public function allianceMembership()
    {
        return $this->memberships()->where('owner_type', Alliance::class);
    }
}
