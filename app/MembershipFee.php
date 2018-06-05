<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\ModifiesAmounts;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class MembershipFee.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
 * @property string amount_type
 * @property float amount
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property Organization organization
 * @property \Illuminate\Database\Eloquent\Collection billingConditions
 */
class MembershipFee extends Model
{
    use UuidTrait, ModifiesAmounts;

    /**
     * Get relation between this membership fee and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
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
