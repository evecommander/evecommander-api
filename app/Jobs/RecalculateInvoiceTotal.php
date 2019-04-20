<?php

namespace App\Jobs;

use App\Invoice;
use App\InvoiceItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculateInvoiceTotal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;

    /**
     * Create a new job instance.
     *
     * @param Invoice $invoice
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice->loadMissing('items');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->invoice->total = $this->invoice->items->reduce(function ($carry, InvoiceItem $item) {
            return $carry + $item->total;
        });

        $this->invoice->save();
    }
}
