<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Handbook.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
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
 * @property Organization organization
 * @property Character createdBy
 * @property Character lastUpdatedBy
 */
class Handbook extends Model
{
    use HasComments;

    /**
     * Get relation between this handbook and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this handbook and the character that created it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Character::class, 'created_by');
    }

    /**
     * Get relation between this handbook and the character that last updated it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class, 'last_updated_by');
    }
}
