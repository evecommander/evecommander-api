<?php

namespace App;

use App\Traits\UuidTrait;
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
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Relations\MorphTo owner
 * @property \Illuminate\Database\Eloquent\Relations\HasMany discounts
 * @property \Illuminate\Database\Eloquent\Relations\BelongsToMany membershipFees
 */
class BillingCondition extends Model
{
    use UuidTrait;

    /**
     * Get relation between this billing condition and it's owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
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
