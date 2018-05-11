<?php

namespace App;

use App\Traits\ModifiesAmounts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Discount
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
 * @property string billing_condition_id
 * @property string amount_type
 * @property double amount
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Discount extends Model
{
    use ModifiesAmounts;
    //
}
