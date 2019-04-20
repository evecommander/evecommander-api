<?php

namespace App\Abstracts;

use App\BillingCondition;
use App\BillingConditionGroup;
use App\Character;
use App\Invoice;
use App\MembershipLevel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModifiedAmounts.
 *
 * @property string amount_type
 * @property float amount
 * @property BillingCondition|BillingConditionGroup conditional
 * @property Organization organization
 */
abstract class ModifiedAmounts extends Model
{
    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENT = 'percent';
    const TYPE_PER_MEMBER = 'per_member';

    const ALLOWED_TYPES = [
        self::TYPE_FIXED,
        self::TYPE_PERCENT,
        self::TYPE_PER_MEMBER,
    ];

    /**
     * Returns the type of the modification.
     *
     * @return string
     */
    protected function getType()
    {
        return $this->amount_type;
    }

    /**
     * Returns the amount of the modification.
     *
     * @return float
     */
    protected function getAmount()
    {
        return $this->amount;
    }

    /**
     * Returns whether the modifier is meant to be a flat amount.
     *
     * @return bool
     */
    public function isFixed()
    {
        return $this->getType() === self::TYPE_FIXED;
    }

    /**
     * Returns whether the modifier is meant to be calculated as a percent of the invoice's total.
     *
     * @return bool
     */
    public function isPercent()
    {
        return $this->getType() === self::TYPE_PERCENT;
    }

    /**
     * Returns whether the modifier is meant to be calculated on a per member basis.
     *
     * @return bool
     */
    public function isPerMember()
    {
        return $this->getType() === self::TYPE_PER_MEMBER;
    }

    public function getQuantity(Invoice $invoice)
    {
        if ($this->isPerMember()) {
            /** @var Organization|Character $recipient */
            $recipient = $invoice->recipient()->with('members')->get();

            return $recipient instanceof Organization ? $recipient->members->count() : 1;
        }

        return 1;
    }

    /**
     * Calculates and returns the amount of the modification this represents.
     *
     * @param Invoice $invoice
     *
     * @return float|int
     */
    public function calculateTotal(Invoice $invoice)
    {
        if ($this->isPercent()) {
            return $this->getAmount() * $invoice->currentTotal();
        }

        return $this->getAmount() * $this->getQuantity($invoice);
    }

    /**
     * @param $subject
     * @param $action
     *
     * @return bool
     */
    public function isApplicable($subject, $action)
    {
        $this->loadMissing(['conditional']);

        return $this->conditional ? $this->conditional->conditionPasses($subject, $action) : true;
    }

    /**
     * Get relation between this membership fee and any billing conditions that are tied to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function conditional()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this membership fee and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    public function membershipLevels()
    {
        return $this->morphToMany(MembershipLevel::class, 'chargable');
    }
}
