<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rsvp.
 *
 * @property string id
 * @property string fleet_id
 * @property string character_id
 * @property int response
 * @property string notes
 * @property bool confirmed
 * @property string confirmation_notes
 * @property \Illuminate\Support\Carbon created_at
 * @property \Illuminate\Support\Carbon updated_at
 *
 * Relationships
 * @property Character character
 * @property Fleet fleet
 */
class Rsvp extends Model
{
    use UuidTrait;

    const RESPONSE_YES = 'yes';
    const RESPONSE_MAYBE = 'maybe';
    const RESPONSE_PENDING = 'pending';
    const RESPONSE_NO = 'no';

    const AVAILABLE_RESPONSES = [
        self::RESPONSE_YES,
        self::RESPONSE_MAYBE,
        self::RESPONSE_PENDING,
        self::RESPONSE_NO,
    ];

    protected $casts = [
        'confirmed' => 'boolean',
    ];

    /**
     * Get relation between this RSVP and the fleet it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    /**
     * Get relation between this RSVP and the character it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
