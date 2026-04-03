<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait OwnedByUser
{
    public static function bootOwnedByUser()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function scopeOwnedByUser(Builder $query)
    {
        if (auth()->check()) {
            return $query->where('user_id', auth()->id());
        }
        return $query;
    }
}
