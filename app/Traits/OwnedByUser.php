<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait OwnedByUser
{
    public function scopeOwnedByUser(Builder $query)
    {
        if (auth()->check()) {
            return $query->where('user_id', auth()->id());
        }
        return $query;
    }
}
