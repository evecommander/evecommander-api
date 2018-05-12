<?php

namespace App;

use App\Traits\Commentable;
use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceItem
 *
 * @property string id
 * @property string name
 * @property string description
 * @property int quantity
 * @property double cost
 * @property string created_at
 * @property string updated_at
 */
class InvoiceItem extends Model
{
    use HasComments, UuidTrait;

    /**
     * Get the total cost of the invoice item
     *
     * @return float|int
     */
    public function getTotal()
    {
        return $this->quantity * $this->cost;
    }
}
