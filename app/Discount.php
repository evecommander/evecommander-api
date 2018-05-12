<?php

namespace App;

use App\Traits\ModifiesAmounts;
use App\Traits\UuidTrait;
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
    use ModifiesAmounts, UuidTrait;

    /**
     * Get the relation between this discount and it's owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this discount and the billing condition that belongs to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function billingCondition()
    {
        return $this->belongsTo(BillingCondition::class);
    }
}
