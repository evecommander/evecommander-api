<?php

namespace App;

use App\Traits\Commentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package App
 *
 * @property int id
 * @property int commentable_id
 * @property string commentable_type
 * @property int character_id
 * @property string text
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Comment extends Model
{
    use Commentable;

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
