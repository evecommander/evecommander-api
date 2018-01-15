<?php

namespace App\Traits;

use App\Membership;

/**
 * Trait IsMember
 * @package App\Traits
 *
 * @method morphMany(string $related, string $name)
 */
trait IsMember
{
    public function memberships()
    {
        return $this->morphMany(Membership::class, 'member');
    }
}