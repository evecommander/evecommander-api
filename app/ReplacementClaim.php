<?php

namespace App;

use App\Abstracts\Organization;
use App\Notifications\ReplacementClaim\PaymentPosted;
use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class ReplacementClaim.
 *
 * @property string id
 * @property string code
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
 * @property string last_updated_by
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property Character character
 * @property Organization organization
 * @property Fitting fitting
 * @property Character lastUpdatedBy
 */
class ReplacementClaim extends Model
{
    use HasComments, Notifiable, UuidTrait;

    const STATUS_PENDING = 'pending';
    const STATUS_CONTESTED = 'contested';
    const STATUS_CLOSED = 'closed';
    const STATUS_PAYED = 'payed';
    const STATUS_ACCEPTED = 'accepted';

    const AVAILABLE_STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_CONTESTED,
        self::STATUS_CLOSED,
        self::STATUS_PAYED,
        self::STATUS_ACCEPTED,
    ];

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

    /**
     * Get any payments posted for the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments()
    {
        return $this->notifications()->where('type', PaymentPosted::class);
    }

    /**
     * Get Character that last updated this ReplacementClaim.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class, 'last_updated_by');
    }
}
