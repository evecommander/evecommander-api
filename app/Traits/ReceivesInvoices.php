<?php

namespace App\Traits;
use App\Invoice;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait HasInvoices
 * @package App\Traits
 *
 * @method morphMany(string $related, string $name)
 */
trait ReceivesInvoices
{
    /**
     * Returns array of subscribed users
     *
     * @return Collection
     */
    abstract public function receivedInvoiceSubscribers();

    /**
     * Get all invoices belonging to this model
     *
     * @return MorphMany
     */
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'recipient');
    }

    /**
     * Get all fulfilled invoices belonging to this model
     *
     * @return MorphMany
     */
    public function fulfilledInvoices()
    {
        return $this->invoices()->where('state', Invoice::STATE_FULFILLED);
    }

    /**
     * Get all overdue invoices belonging to this model
     *
     * @return MorphMany
     */
    public function overdueInvoices()
    {
        return $this->invoices()->where('state', Invoice::STATE_OVERDUE);
    }

    /**
     * Get all pending invoices belonging to this model
     *
     * @return MorphMany
     */
    public function pendingInvoices()
    {
        return $this->invoices()->where('state', Invoice::STATE_PENDING);
    }

    /**
     * Get all invoices that are in default belonging to this model
     *
     * @return MorphMany
     */
    public function defaultInvoices()
    {
        return $this->invoices()->where('state', Invoice::STATE_IN_DEFAULT);
    }
}