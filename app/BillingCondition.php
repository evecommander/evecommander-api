<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class BillingCondition.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
 * @property string name
 * @property string description
 * @property string type
 * @property int|null quantity
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection organization
 * @property \Illuminate\Database\Eloquent\Collection discounts
 * @property \Illuminate\Database\Eloquent\Collection membershipFees
 */
class BillingCondition extends Model
{
    use UuidTrait;

    /**
     * Get relation between this billing condition and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this billing condition and any discounts that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    /**
     * Get relation between this billing condition and any membership fees that are tied to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function membershipFees()
    {
        return $this->belongsToMany(MembershipFee::class)->withPivotValue('sort')->orderBy('sort');
    }
}
