<?php

namespace App\Traits;
use App\Handbook;

/**
 * Trait HasHandbooks
 * @package App\Traits
 *
 * @method morphMany(string $related, string $name)
 */
trait HasHandbooks
{
    public function handbooks()
    {
        return $this->morphMany(Handbook::class, 'owner');
    }
}