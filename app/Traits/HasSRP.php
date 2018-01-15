<?php

namespace App\Traits;

use App\ReplacementClaim;

/**
 * Trait HasSRP
 * @package App\Traits
 *
 * @method morphMany(string $related, string $name)
 */
trait HasSRP
{
    public function claims()
    {
        return $this->morphMany(ReplacementClaim::class, 'organization');
    }
}