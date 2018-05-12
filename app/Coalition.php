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

    public function leader()
    {
        return $this->belongsTo(Character::class, 'leader_character_id');
    }

    public function alliances()
    {
        return $this->members()->where('member_type', Alliance::class)->with('member');
    }
}
