<?php

namespace App\JsonApi\Adapters;

use App\Invoice;
use App\InvoiceItem;
use App\Jobs\RecalculateInvoiceTotal;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class InvoiceItemAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'created-at',
        'updated-at',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new InvoiceItem(), $paging);
    }

    public function comments()
    {
        return $this->hasMany();
    }

    public function invoice()
    {
        return $this->belongsTo();
    }

    /**
     * Update the invoice total when an invoice item is updated.
     *
     * @param InvoiceItem $invoiceItem
     */
    protected function saved(InvoiceItem $invoiceItem)
    {
        /** @var Invoice $invoice */
        $invoice = $invoiceItem->invoice()->get();
        RecalculateInvoiceTotal::dispatch($invoice);
    }
}
