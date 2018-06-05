<?php

namespace App\Jobs;

use App\Invoice;
use App\Notifications\Invoice\StatusChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessInvoiceStatuses implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;
    protected $initialStatus;

    /**
     * Create a new job instance.
     *
     * @param Invoice $invoice
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->initialStatus = $this->invoice->status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->isFulfilled()) {
            return;
        }

        $this->checkPayments();

        if ($this->isFulfilled()) {
            $this->sendNotification();

            return;
        }

        $this->checkDates();

        $this->sendNotification();
    }

    /**
     * Send a StatusChanged notification iif the status has changed.
     */
    protected function sendNotification()
    {
        if ($this->initialStatus !== $this->invoice->status) {
            $this->invoice->notify(new StatusChanged($this->invoice));
        }
    }

    /**
     * Return whether the invoice is marked as fulfilled.
     *
     * @return bool
     */
    protected function isFulfilled()
    {
        return $this->invoice->status === Invoice::STATE_FULFILLED;
    }

    /**
     * Check whether the last payment on the invoice cleared the remaining balance. If it has, update the status.
     */
    protected function checkPayments()
    {
        $lastPayment = $this->invoice->payments->first();

        if (!isset($lastPayment)) {
            return;
        }

        if ($lastPayment->data['balance_due'] === 0) {
            $this->invoice->status = Invoice::STATE_FULFILLED;
            $this->invoice->save();
        }
    }

    /**
     * Check whether the invoice's due dates have been reached.
     */
    protected function checkDates()
    {
        if ($this->invoice->due_date->isPast()) {
            $this->invoice->status = Invoice::STATE_OVERDUE;
        }

        if ($this->invoice->hard_due_date->isPast()) {
            $this->invoice->status = Invoice::STATE_IN_DEFAULT;
        }

        $this->invoice->save();
    }
}
