<?php

namespace App\Console\Commands;

use App\Invoice;
use App\Jobs\ProcessInvoicePayments;
use App\Jobs\ProcessInvoiceStatuses;
use Illuminate\Console\Command;

class ProcessInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all open invoices for new payments and transitioning to new statuses.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Starting processing of invoices');
        Invoice::with([
            'issuer',
            'items',
            'payments',
        ])
            ->where('status', '!=', Invoice::STATE_FULFILLED)
            ->get()
            ->map(function (Invoice $invoice) {
                $this->line("Queueing job chain for {$invoice->id}");
                ProcessInvoicePayments::dispatch($invoice)->chain([
                    new ProcessInvoiceStatuses($invoice),
                ]);
            });

        return 0;
    }
}
