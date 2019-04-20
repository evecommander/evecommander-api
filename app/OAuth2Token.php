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
 * @property Character character
 */
class OAuth2Token extends Model
{
    use UuidTrait;

    protected $hidden = [
        'refresh_token' // the client is forced to have the server refresh the token on it's behalf
    ];

    /**
     * Get the character that owns this OAuth2Token.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Accessor for Refresh Token field.
     *
     * @param $value
     * @return mixed
     */
    public function getRefreshTokenAttribute($value)
    {
        return decrypt($value, false);
    }

    /**
     * Mutator for Refresh Token field.
     *
     * @param $value
     */
    public function setRefreshTokenAttribute($value)
    {
        $this->attributes['refresh_token'] = encrypt($value, false);
    }
}
