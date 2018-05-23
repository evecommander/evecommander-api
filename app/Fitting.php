<?php

namespace App;

use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Fitting.
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
 * @property string name
 * @property string description
 * @property int api_id
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property \Illuminate\Database\Eloquent\Collection doctrine
 * @property \Illuminate\Database\Eloquent\Collection owner
 * @property \Illuminate\Database\Eloquent\Collection replacementClaims
 */
class Fitting extends Model
{
    use UuidTrait, HasComments;

    /**
     * Get relation between this fitting and the doctrine it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctrine()
    {
        return $this->belongsTo(Doctrine::class);
    }

    /**
     * Get relation between this fitting and it's owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this fitting and any replacement claims that are regarding it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replacementClaims()
    {
        return $this->hasMany(ReplacementClaim::class);
    }
}
