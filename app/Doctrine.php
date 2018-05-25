<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Doctrine.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
 * @property string name
 * @property string description
 * @property int priority
 * @property string created_by
 * @property string last_updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection organization
 * @property \Illuminate\Database\Eloquent\Collection fittings
 * @property \Illuminate\Database\Eloquent\Collection createdBy
 * @property \Illuminate\Database\Eloquent\Collection lastUpdatedBy
 */
class Doctrine extends Model
{
    use UuidTrait;

    /**
     * Get relation between this doctrine and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this doctrine and any fittings that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fittings()
    {
        return $this->hasMany(Fitting::class);
    }

    /**
     * Get relation between this doctrine and the character that created it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get relation between this doctrine and the character that last updated it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class);
    }
}
