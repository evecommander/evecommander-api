<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasSettings;
use App\Traits\HasSRP;
use App\Traits\IssuesInvoices;
use App\Traits\ReceivesInvoices;
use Carbon\Carbon;

/**
 * Class Coalition
 * @package App
 *
 * @property string $id
 * @property int $leader_character_id
 * @property string $name
 * @property string $description
 * @property string $logo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Coalition extends Organization
{
    use HasSRP, ReceivesInvoices, IssuesInvoices;

    public function receivedInvoiceSubscribers()
    {
        $subscriberIds = $this->settings->value['invoices']['received']['subscribers'];

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
}
