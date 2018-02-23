<?php

namespace App\Traits;

use App\Membership;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait IsMember
 * @package App\Traits
 *
 * @method morphMany(string $related, string $name)
 */
trait IsMember
{
    /**
     * Get any memberships the model is a part of
     *
     * @return MorphMany
     */
    public function memberships()
    {
        return $this->morphMany(Membership::class, 'member');
    }
}