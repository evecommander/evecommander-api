<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @package App
 *
 * @property string id
 * @property
 */
class Setting extends Model
{
    use UuidTrait;

    public $incrementing = false;

    protected $casts = [
        'value' => 'array'
    ];

    /**
     * Get the owning model for this setting
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }
}
