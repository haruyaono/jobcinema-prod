<?php

namespace App\Job\CongratsMonies;

use Illuminate\Database\Eloquent\Model;
use App\Job\Categories\Category;


class CongratsMoney extends Model
{

    protected $table = 'congrats_monies';
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

    public function getCostomAmountAttribute()
    {
        return number_format($this->amount) . "円";
    }
}
