<?php

namespace App\Traits;

use App\Invoice;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait ReceivesInvoices.
 *
 * @method morphMany(string $related, string $name)
 */
trait ReceivesInvoices
{
    /**
     * Get all invoices where this model is the issuer.
     *
     * @return MorphMany
     */
    public function receivedInvoices()
    {
        return $this->morphMany(Invoice::class, 'issuer');
    }

    /**
     * Get all fulfilled invoices belonging to this model.
     *
     * @return MorphMany
     */
    public function fulfilledReceivedInvoices()
    {
        return $this->receivedInvoices()->where('state', Invoice::STATE_FULFILLED);
    }

    /**
     * Get all overdue invoices belonging to this model.
     *
     * @return MorphMany
     */
    public function overdueReceivedInvoices()
    {
        return $this->receivedInvoices()->where('state', Invoice::STATE_OVERDUE);
    }

    /**
     * Get all pending invoices belonging to this model.
     *
     * @return MorphMany
     */
    public function pendingReceivedInvoices()
    {
        return $this->receivedInvoices()->where('state', Invoice::STATE_PENDING);
    }

    /**
     * Get all invoices that are in default belonging to this model.
     *
     * @return MorphMany
     */
    public function defaultReceivedInvoices()
    {
        return $this->receivedInvoices()->where('state', Invoice::STATE_IN_DEFAULT);
    }
}
