<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UuidTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (method_exists(static::class, 'onCreate')) {
                static::onCreate($model);
            }

            if ($model->{$model->getKeyName()}) {
                return;
            }

            $model->{$model->getKeyName()} = Str::orderedUuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }
}
