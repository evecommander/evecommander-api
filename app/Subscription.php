<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Subscription.
 *
 * @property string id
 * @property string character_id
 * @property string organization_id
 * @property string organization_type
 * @property array settings
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection character
 * @property \Illuminate\Database\Eloquent\Collection organization
 */
class Subscription extends Model
{
    use UuidTrait;

    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get the relation between this subscription and the character that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get the relation between this subscription and the organization it points to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }
}
