<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class AchievementReward extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * get amount
     *
     * @return string
     */
    public function getCustomAmountAttribute()
    {
        return number_format("{$this->amount}") . "円(税別)";
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
