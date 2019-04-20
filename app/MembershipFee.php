<?php

namespace App;

use App\Abstracts\ModifiedAmounts;
use App\Traits\UuidTrait;
use Illuminate\Support\Carbon;

/**
 * Class MembershipFee.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
 * @property string conditional_id
 * @property string conditional_type
 * @property string name
 * @property string amount_type
 * @property float amount
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class MembershipFee extends ModifiedAmounts
{
    use UuidTrait;
}
