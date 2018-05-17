<?php

namespace App\Traits;
use App\Handbook;

/**
 * Trait HasHandbooks
 *
 * @method morphMany(string $related, string $name)
 */
trait HasHandbooks
{
    /**
     * Get relation between this model and any handbooks that it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function handbooks()
    {
        return $this->morphMany(Handbook::class, 'owner');
    }
}