<?php
namespace App\Traits;

use App\Invoice;

/**
 * Trait ModifiesAmounts
 * @package App\Traits
 *
 * @property string amount_type
 * @property double amount
 */
trait ModifiesAmounts
{
    /**
     * Returns the type of the modification
     *
     * @return string
     */
    protected function getType()
    {
        return $this->amount_type;
    }

    /**
     * Returns the amount of the modification
     *
     * @return double
     */
    protected function getAmount()
    {
        return $this->amount;
    }

    /**
     * Returns whether the modifier is meant to be a flat amount
     *
     * @return bool
     */
    public function isFixed()
    {
        return $this->getType() === 'fixed';
    }

    /**
     * Returns whether the modifier is meant to be calculated as a percent of the invoice's total
     *
     * @return bool
     */
    public function isPercent()
    {
        return $this->getType() === 'percent';
    }

    /**
     * Returns whether the modifier is meant to be calculated on a per member basis
     *
     * @return bool
     */
    public function isPerMember()
    {
        return $this->getType() === 'per_member';
    }

    /**
     * Calculates and returns the amount of the modification this represents
     *
     * @param Invoice $invoice
     *
     * @return float|int
     */
    public function calculateTotal(Invoice $invoice)
    {
        if ($this->isFixed()) {
            return $this->getAmount();
        } elseif ($this->isPercent()) {
            return $this->getAmount() * $invoice->currentTotal();
        } elseif ($this->isPerMember()) {
            $members = $invoice->recipient()->with('members')->get()->members;

            return $this->getAmount() * count($members);
        }
    }
}