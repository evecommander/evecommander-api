<?php

namespace App\Traits;
use App\Invoice;
use App\User;

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
     * @return User[]
     */
    abstract public function receivedInvoiceSubscribers();

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'recipient');
    }

    public function fulfilledInvoices()
    {
        return $this->invoices()->where('state', Invoice::STATE_FULFILLED);
    }

    public function overdueInvoices()
    {
        return $this->invoices()->where('state', Invoice::STATE_OVERDUE);
    }

    public function pendingInvoices()
    {
        return $this->invoices()->where('state', Invoice::STATE_PENDING);
    }
}