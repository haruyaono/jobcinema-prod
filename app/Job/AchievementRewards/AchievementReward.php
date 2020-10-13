<?php

namespace App\Job\AchievementRewards;

use Illuminate\Database\Eloquent\Model;
use App\Job\Categories\Category;


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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
