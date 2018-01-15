<?php

namespace App;

use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceItem
 * @package App
 */
class InvoiceItem extends Model
{
    use Commentable;
}
