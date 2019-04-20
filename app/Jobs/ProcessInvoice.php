<?php

namespace App\Jobs;

use App\BillingCondition;
use App\Discount;
use App\Invoice;
use App\InvoiceItem;
use App\Membership;
use App\MembershipFee;
use App\MembershipLevel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProcessInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const ACTION_JOINING = BillingCondition::TYPE_JOINING;
    const ACTION_EXITING = BillingCondition::TYPE_EXITING;
    const ACTION_RENEWING = 'renewing';

    protected $membership;
    protected $action;

    /**
     * Create a new job instance.
     *
     * @param Membership $membership
     * @param string     $action
     *
     * @return void
     */
    public function __construct(Membership $membership, string $action)
    {
        $this->membership = $membership->loadMissing([
            'membershipLevel.fees',
            'membershipLevel.discounts',
            'member',
            'organization',
        ]);
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var MembershipLevel $membershipLevel */
        $membershipLevel = $this->membership->membershipLevel;
        $fees = collect();

        if (($membershipLevel->dues_structure === MembershipLevel::DUES_STRUCTURE_UPON_JOINING &&
            $this->action === BillingCondition::TYPE_JOINING) ||
            $this->action === BillingCondition::TYPE_EXITING) {
            $fees = $membershipLevel->fees->filter(function (MembershipFee $fee) {
                return $fee->isApplicable($this->membership->member, $this->action);
            });
        }

        if (count($fees) > 0) {
            DB::transaction(function () use ($fees) {
                $invoice = $this->createInvoice();

                // percent fees will be pulled out for later
                $percentFees = $fees->filter(function (MembershipFee $membershipFee) {
                    return $membershipFee->isPercent();
                });

                $fees = $fees->diff($percentFees);

                /** @var MembershipFee $fee */
                foreach ($fees as $fee) {
                    $this->createInvoiceItem($invoice, $fee);
                }

                // get global discounts
                $discounts = $this->membership->organization->discounts()->whereNull('membership_level_id')->get();
                $discounts = $discounts->merge($this->membership->membershipLevel->discounts)
                    ->sort(function (Discount $discount) {
                        return $discount->isPercent();
                    });

                /** @var Discount $discount */
                foreach ($discounts as $discount) {
                    $this->createInvoiceItem($invoice, $discount);
                }

                /** @var MembershipFee $percentFee */
                foreach ($percentFees as $percentFee) {
                    $this->createInvoiceItem($invoice, $percentFee);
                }

                // save again to update the total
                $invoice->save();
            });
        }
    }

    /**
     * Create a new invoice.
     *
     * @return Invoice
     */
    protected function createInvoice()
    {
        $invoice = new Invoice();
        $invoice->name = Str::title("{$this->action} membership of ").$this->membership->organization->name;
        $invoice->status = Invoice::STATE_PENDING;
        $invoice->recipient()->associate($this->membership->member);
        $invoice->issuer()->associate($this->membership->organization);
        $invoice->save();

        return $invoice;
    }

    /**
     * Create an invoice item from the given membership fee or discount.
     *
     * @param Invoice                $invoice
     * @param MembershipFee|Discount $source
     *
     * @return InvoiceItem
     */
    protected function createInvoiceItem(Invoice $invoice, $source)
    {
        $invoiceItem = new InvoiceItem();
        $invoiceItem->name = $source->name;
        $invoiceItem->description = '';
        $invoiceItem->quantity = $source->getQuantity($invoice);
        $invoiceItem->cost = $source->amount;
        $invoiceItem->total = $source->calculateTotal($invoice);
        $invoiceItem->invoice()->associate($invoice);
        $invoiceItem->save();

        return $invoiceItem;
    }
}
