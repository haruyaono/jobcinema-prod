<?php

namespace App\Job\Categories;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;  

    protected $fillable = ['name', 'slug'];
    protected $dates = ['created_at', 'updated_at'];

    public function jobs()
    {
      return $this->hasMany('App\Job\JobItems\JobItem');
    }
}
