<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface IssuesInvoicesContract
 *
 * @property Collection invoices
 * @property Collection fulfilledInvoices
 * @property Collection overdueInvoices
 * @property Collection pendingInvoices
 * @property Collection defaultInvoices
 */
interface IssuesInvoicesContract
{
    /**
     * Get all invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function invoices();

    /**
     * Get all fulfilled invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fulfilledInvoices();

    /**
     * Get all overdue invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function overdueInvoices();

    /**
     * Get all pending invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function pendingInvoices();

    /**
     * Get all invoices that are in default belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function defaultInvoices();
}