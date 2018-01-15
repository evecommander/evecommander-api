<?php

namespace App\Traits;

use App\Setting;

/**
 * Trait HasSettings
 * @package App\Traits
 *
 * @method morphMany(string $related, string $name)
 */
trait HasSettings
{
    public function settings()
    {
        return $this->morphMany(Setting::class, 'owner');
    }
}