<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchieveRewardBilling extends Model
{
    protected $table = 'achieve_reward_billing';

    protected $fillable = [
        'apply_id',
        'is_payed',
        'payed_at',
        'is_return_requested',
        'return_requested_at',
        'is_returned',
    ];

    protected $dates = [
        'payed_at',
        'return_requested_at',
        'created_at',
        'updated_at',
    ];

    public function apply()
    {
        return $this->belongsTo(Apply::class);
    }
}
