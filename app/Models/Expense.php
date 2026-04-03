<?php

namespace App\Models;

use App\Traits\OwnedByUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use OwnedByUser;

    protected $fillable = ['user_id', 'category_id', 'account_id', 'savings_target_id', 'amount', 'date', 'description'];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function savingsTarget(): BelongsTo
    {
        return $this->belongsTo(SavingsTarget::class);
    }

    protected $casts = [
        'date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
