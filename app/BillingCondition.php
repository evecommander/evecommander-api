<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class BillingCondition
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
 * @property string name
 * @property string description
 * @property string type
 * @property int|null quantity
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class BillingCondition extends Model
{
    //
}
