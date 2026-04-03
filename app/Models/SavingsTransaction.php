<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingsTransaction extends Model
{
    protected $fillable = ['savings_target_id', 'account_id', 'amount', 'date', 'note'];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    protected $casts = [
        'date' => 'date',
    ];

    public function target(): BelongsTo
    {
        return $this->belongsTo(SavingsTarget::class, 'savings_target_id');
    }
}
