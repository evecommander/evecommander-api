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
    public function replacementClaims()
    {
        return $this->morphMany(ReplacementClaim::class, 'organization');
    }
}
