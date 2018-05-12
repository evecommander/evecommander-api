<?php

namespace App;

use App\Abstracts\Organization;
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
 * @property string default_membership_level
 * @property array settings
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Alliance extends Organization
{
    use HasSRP, ReceivesInvoices, IssuesInvoices, Notifiable;

    protected $casts = [
        'settings' => 'array'
    ];

    /**
     * Get collection of subscribers for invoice events.
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

    /**
     * Get relation between this alliance and the coalition it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function coalition()
    {
        return $this->memberships()->where('owner_type', Coalition::class)->with('owner');
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
