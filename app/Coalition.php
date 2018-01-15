<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasSettings;
use App\Traits\HasSRP;
use App\Traits\ReceivesInvoices;

class Coalition extends Organization
{
    use HasSettings, HasSRP, ReceivesInvoices;

    public function receivedInvoiceSubscribers()
    {
        $subscriberIds = $this->settings()->value['invoices']['received']['subscribers'];

        if (empty($subscriberIds)) {
            return [$this->leader()];
        }

        $subscribers = [];
        foreach ($subscriberIds as $id) {
            $subscribers[] = User::find($id);
        }

        return $subscribers;
    }

    public function leader()
    {
        return $this->belongsTo(Character::class, 'leader_character_id');
    }
}
