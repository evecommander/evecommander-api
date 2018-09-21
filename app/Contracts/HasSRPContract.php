<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface HasSRPContract
 *
 * @property Collection replacementClaims
 * @property Collection pendingReplacementClaims
 * @property Collection closedReplacementClaims
 * @property Collection acceptedReplacementClaims
 * @property Collection contestedReplacementClaims
 * @property Collection payedReplacementClaims
 */
interface HasSRPContract
{
    /**
     * Get relation between this model and any replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function replacementClaims();

    /**
     * Get relation between this model and any pending replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function pendingReplacementClaims();

    /**
     * Get relation between this model and any closed replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function closedReplacementClaims();

    /**
     * Get relation between this model and any accepted replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function acceptedReplacementClaims();

    /**
     * Get relation between this model and any contested replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function contestedReplacementClaims();

    /**
     * Get relation between this model and any payed replacement claims that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payedReplacementClaims();
}