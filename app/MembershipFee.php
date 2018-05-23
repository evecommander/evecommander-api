<?php

namespace App;

use App\Traits\ModifiesAmounts;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class MembershipFee.
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
 * @property string amount_type
 * @property float amount
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection owner
 * @property \Illuminate\Database\Eloquent\Collection billingConditions
 */
class MembershipFee extends Model
{
    use UuidTrait, ModifiesAmounts;

    /**
     * Get relation between this membership fee and it's owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this membership fee and any billing conditions that are tied to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function billingConditions()
    {
        return $this->belongsToMany(BillingCondition::class)->withPivotValue('sort')->orderBy('sort');
    }
}
