<?php

namespace App;

use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceItem.
 *
 * @property string id
 * @property string name
 * @property string description
 * @property int quantity
 * @property float cost
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property \Illuminate\Database\Eloquent\Collection invoice
 */
class InvoiceItem extends Model
{
    use HasComments, UuidTrait;

    /**
     * Get relation between this invoice item and the invoice it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
