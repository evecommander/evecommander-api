<?php

namespace App\Broadcasting;

use App\Invoice;
use App\User;

class InvoiceChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User    $user
     * @param  \App\Invoice $invoice
     * @return array|bool
     */
    public function join(User $user, Invoice $invoice)
    {
        return $user->can('read', [$invoice, request()]);
    }
}
