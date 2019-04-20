<?php

namespace App\Policies\Traits;

trait AuthorizesReceivedInvoicesRelation
{
    /**
     * Determine whether the user can modify received invoices.
     *
     * @return bool
     */
    public function modifyReceivedInvoices()
    {
        return false;
    }
}
