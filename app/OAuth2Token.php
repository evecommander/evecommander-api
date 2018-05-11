<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class OAuth2Token extends Model
{
    use UuidTrait;

    /**
     * Get the character that owns this OAuth2Token
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
