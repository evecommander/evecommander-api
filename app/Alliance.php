<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasSettings;
use App\Traits\HasSRP;
use App\Traits\ReceivesInvoices;

class Alliance extends Organization
{
    use HasSettings, HasSRP, ReceivesInvoices;

    public function receivedInvoiceSubscribers()
    {
        // TODO: Implement receivedInvoiceSubscribers() method.
    }
}
