<?php

namespace App;

use App\Traits\Commentable;
use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class ReplacementClaim
 *
 * @property string id
 * @property string character_id
 * @property string organization_id
 * @property string organization_type
 * @property string fitting_id
 * @property int killmail_id
 * @property string killmail_hash
 * @property double total
 * @property string status
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class ReplacementClaim extends Model
{
    use HasComments, Notifiable, UuidTrait;

    /**
     * Get Character that this ReplacementClaim belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get Organization that this ReplacementClaim belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }
}
