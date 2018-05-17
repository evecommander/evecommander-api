<?php

namespace App;

use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class ReplacementClaim.
 *
 * @property string id
 * @property string character_id
 * @property string organization_id
 * @property string organization_type
 * @property string fitting_id
 * @property int killmail_id
 * @property string killmail_hash
 * @property float total
 * @property string status
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany comments
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo character
 * @property \Illuminate\Database\Eloquent\Relations\MorphTo organization
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo fitting
 */
class ReplacementClaim extends Model
{
    use HasComments, Notifiable, UuidTrait;

    /**
     * Get Character that this ReplacementClaim belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get Organization that this ReplacementClaim belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this replacement claim and the fitting it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fitting()
    {
        return $this->belongsTo(Fitting::class);
    }
}
