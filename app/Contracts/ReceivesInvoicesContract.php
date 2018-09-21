<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface ReceivesInvoicesContract
 *
 * @property Collection receivedInvoices
 * @property Collection fulfilledReceivedInvoices
 * @property Collection overdueReceivedInvoices
 * @property Collection pendingReceivedInvoices
 * @property Collection defaultReceivedInvoices
 */
interface ReceivesInvoicesContract
{
    /**
     * Get all invoices where this model is the issuer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function receivedInvoices();

    /**
     * Get all fulfilled invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fulfilledReceivedInvoices();

    /**
     * Get all overdue invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function overdueReceivedInvoices();

    /**
     * Get all pending invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function pendingReceivedInvoices();

    /**
     * Get all invoices that are in default belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function defaultReceivedInvoices();
}