<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\ModifiesAmounts;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Discount.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
 * @property string billing_condition_id
 * @property string amount_type
 * @property float amount
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property Organization organization
 * @property BillingCondition billingCondition
 */
class Discount extends Model
{
    use ModifiesAmounts, UuidTrait;

    /**
     * Get the relation between this discount and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
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
