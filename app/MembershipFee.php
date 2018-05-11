<?php

namespace App;

use App\Traits\ModifiesAmounts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class MembershipFee
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
 * @property string amount_type
 * @property double amount
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class MembershipFee extends Model
{
    use ModifiesAmounts;
    //
}
