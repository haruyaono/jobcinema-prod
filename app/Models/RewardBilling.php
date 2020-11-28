<?php

namespace App\Models;

use App\Models\User;
use App\Models\Apply;
use  \Illuminate\Database\Eloquent\Relations\BelongsTo;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class RewardBilling extends Model
{
    protected $guarded = ['id'];

    protected $dates = [
        'payment_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function apply(): BelongsTo
    {
        return $this->belongsTo(Apply::class);
    }

    public function getCustomAmountAttribute()
    {
        return number_format($this->billing_amount) . "円";
    }
}
