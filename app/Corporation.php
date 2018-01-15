<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasSettings;
use App\Traits\HasSRP;
use App\Traits\ReceivesInvoices;

class Corporation extends Organization
{
    use HasSettings, HasSRP, ReceivesInvoices;

    public function receivedInvoiceSubscribers()
    {
        $subscriberIds = $this->settings()->value['invoices']['received']['subscribers'];

        $subscribers = [];
        foreach ($subscriberIds as $id) {
            $subscribers[] = User::find($id);
        }

        return $subscribers;
    }
}
