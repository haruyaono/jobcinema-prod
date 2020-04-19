<?php

namespace App\Job\Categories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DateCategory extends Model
{
    use SoftDeletes;  

    protected $fillable = ['name'];
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function jobs()
    {
        return $this->hasMany('App\Job\JobItems\JobItem');
    }
}
