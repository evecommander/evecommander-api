<?php

namespace App;

use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Handbook.
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
 * @property int|null order
 * @property string title
 * @property string description
 * @property string content
 * @property string created_by
 * @property string last_updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property \Illuminate\Database\Eloquent\Collection owner
 * @property \Illuminate\Database\Eloquent\Collection createdBy
 * @property \Illuminate\Database\Eloquent\Collection lastUpdatedBy
 */
class Handbook extends Model
{
    use HasComments;

    /**
     * Get the owning model of the handbook.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Get the character that created the handbook.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Character::class, 'created_by');
    }

    /**
     * Get the character that last updated the handbook.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class, 'last_updated_by');
    }
}
