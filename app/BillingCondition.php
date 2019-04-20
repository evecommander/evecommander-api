<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class BillingCondition.
 *
 * @property string id
 * @property string billing_condition_group_id
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
 * @property Organization organization
 * @property \Illuminate\Database\Eloquent\Collection discounts
 * @property \Illuminate\Database\Eloquent\Collection membershipFees
 * @property \Illuminate\Database\Eloquent\Collection billingConditionGroup
 */
class BillingCondition extends Model
{
    use UuidTrait;

    const TYPE_JOINING = 'joining';
    const TYPE_EXITING = 'exiting';
    const TYPE_MIN_MEMBERS = 'min_members';
    const TYPE_MAX_MEMBERS = 'max_members';

    const ALLOWED_TYPES = [
        self::TYPE_JOINING,
        self::TYPE_EXITING,
        self::TYPE_MIN_MEMBERS,
        self::TYPE_MAX_MEMBERS,
    ];

    /**
     * Test whether the condition passes.
     *
     * @param Organization|Character $subject
     * @param string $action
     * @return bool
     */
    public function conditionPasses($subject, $action)
    {
        switch ($this->type) {
            case self::TYPE_JOINING:
            case self::TYPE_EXITING:
                return $action === $this->type;

            case self::TYPE_MIN_MEMBERS:
                if ($subject instanceof Organization) {
                    return $subject->members->count() >= $this->quantity;
                }

                return false;

            case self::TYPE_MAX_MEMBERS:
                if ($subject instanceof Organization) {
                    return $subject->members->count() <= $this->quantity;
                }

                return false;

            default:
                return false;
        }
    }

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
        return $this->morphToMany(MembershipFee::class, 'conditional', 'conditional_membership_fee');
    }

    /**
     * Get relation between this billing condition and the billing condition group that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function billingConditionGroup()
    {
        return $this->belongsTo(BillingConditionGroup::class);
    }
}
