<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface IssuesInvoicesContract.
 *
 * @property Collection issuedInvoices
 * @property Collection fulfilledIssuedInvoices
 * @property Collection overdueIssuedInvoices
 * @property Collection pendingIssuedInvoices
 * @property Collection defaultIssuedInvoices
 */
interface IssuesInvoicesContract
{
    /**
     * Get all invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function issuedInvoices();

    /**
     * Get all fulfilled invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fulfilledIssuedInvoices();

    /**
     * Get all overdue invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function overdueIssuedInvoices();

    /**
     * Get all pending invoices belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function pendingIssuedInvoices();

    /**
     * Get all invoices that are in default belonging to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function defaultIssuedInvoices();
}
