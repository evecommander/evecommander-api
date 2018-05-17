<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class OAuth2Token.
 *
 * @property string id
 * @property string character_id
 * @property string access_token
 * @property Carbon expires_on
 * @property string|null refresh_token
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo character
 */
class OAuth2Token extends Model
{
    use UuidTrait;

    /**
     * Get the character that owns this OAuth2Token.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
