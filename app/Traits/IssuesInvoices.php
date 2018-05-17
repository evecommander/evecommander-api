<?php

namespace App\Traits;

use App\Invoice;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait IssuesInvoices.
 *
 * @method morphMany(string $related, string $name)
 */
trait IssuesInvoices
{
    /**
     * Get all invoices where this model is the issuer.
     *
     * @return MorphMany
     */
    public function issuedInvoices()
    {
        return $this->morphMany(Invoice::class, 'issuer');
    }

    /**
     * Get all fulfilled invoices belonging to this model.
     *
     * @return MorphMany
     */
    public function fulfilledIssuedInvoices()
    {
        return $this->issuedInvoices()->where('state', Invoice::STATE_FULFILLED);
    }

    /**
     * Get all overdue invoices belonging to this model.
     *
     * @return MorphMany
     */
    public function overdueIssuedInvoices()
    {
        return $this->issuedInvoices()->where('state', Invoice::STATE_OVERDUE);
    }

    /**
     * Get all pending invoices belonging to this model.
     *
     * @return MorphMany
     */
    public function pendingIssuedInvoices()
    {
        return $this->issuedInvoices()->where('state', Invoice::STATE_PENDING);
    }

    /**
     * Get all invoices that are in default belonging to this model.
     *
     * @return MorphMany
     */
    public function defaultIssuedInvoices()
    {
        return $this->issuedInvoices()->where('state', Invoice::STATE_IN_DEFAULT);
    }
}
