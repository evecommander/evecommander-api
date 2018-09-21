<?php

namespace App\Traits;

use App\ReplacementClaim;

/**
 * Trait HasSRP.
 *
 * @method morphMany(string $related, string $name)
 */
trait HasSRP
{
    /**
     * Get relation between this model and any replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function replacementClaims()
    {
        return $this->morphMany(ReplacementClaim::class, 'organization');
    }

    /**
     * Get relation between this model and any pending replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function pendingReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_PENDING);
    }

    /**
     * Get relation between this model and any closed replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function closedReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_CLOSED);
    }

    /**
     * Get relation between this model and any accepted replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function acceptedReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_ACCEPTED);
    }

    /**
     * Get relation between this model and any contested replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function contestedReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_CONTESTED);
    }

    /**
     * Get relation between this model and any payed replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payedReplacementClaims()
    {
        return $this->replacementClaims()->where('status', ReplacementClaim::STATUS_PAYED);
    }
}
