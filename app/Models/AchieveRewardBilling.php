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
    ];

    protected $dates = [
        'payed_at',
        'created_at',
        'updated_at',
    ];

}
