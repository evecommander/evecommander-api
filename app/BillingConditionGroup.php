<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class BillingConditionGroup
 * @package App
 *
 * @property string id
 * @property string type
 * @property string organization_id
 * @property string organization_type
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property Organization organization
 * @property \Illuminate\Database\Eloquent\Collection membershipFees
 * @property \Illuminate\Database\Eloquent\Collection billingConditions
 * @property \Illuminate\Database\Eloquent\Collection parentGroup
 * @property \Illuminate\Database\Eloquent\Collection childGroups
 */
class BillingConditionGroup extends Model
{
    use UuidTrait;

    const TYPE_AND = 'and';
    const TYPE_OR = 'or';

    const ALLOWED_TYPES = [
        self::TYPE_AND,
        self::TYPE_OR,
    ];

    /**
     * Test whether the condition group passes.
     *
     * @param Organization|Character $subject
     * @param string $action
     * @return bool
     */
    public function conditionPasses($subject, $action)
    {
        if ($this->type === self::TYPE_AND) {
            $conditionsPass = $this->billingConditions()->get()->every(function (BillingCondition $condition) use ($subject, $action) {
                return $condition->conditionPasses($subject, $action);
            });

            $childrenPass = $this->childGroups()->get()->every(function (BillingConditionGroup $condition) use ($subject, $action) {
                return $condition->conditionPasses($subject, $action);
            });

            return $childrenPass && $conditionsPass;
        }

        $conditionsPass = $this->billingConditions()->get()->contains(function (BillingCondition $condition) use ($subject, $action) {
            return $condition->conditionPasses($subject, $action);
        });

        $childrenPass = $this->childGroups()->get()->contains(function (BillingConditionGroup $condition) use ($subject, $action) {
            return $condition->conditionPasses($subject, $action);
        });

        return $childrenPass || $conditionsPass;
    }

    /**
     * Get relation between this billing condition group and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this billing condition group and any membership fees that are assigned to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function membershipFees()
    {
        return $this->morphToMany(MembershipFee::class, 'conditional', 'conditional_membership_fee');
    }

    /**
     * Get relation between this billing condition group and any billing conditions that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function billingConditions()
    {
        return $this->hasMany(BillingCondition::class);
    }

    /**
     * Get relation between this billing condition group and the billing condition group that it's assigned to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentGroup()
    {
        return $this->belongsTo(BillingConditionGroup::class, 'parent_group_id');
    }

    /**
     * Get relation between this billing condition group and any billing condition groups that are assigned to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childGroups()
    {
        return $this->hasMany(BillingConditionGroup::class, 'parent_group_id');
    }
}
