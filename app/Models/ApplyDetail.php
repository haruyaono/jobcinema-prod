<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplyDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getFullNameAttribute()
    {
        return "{$this->last_name}" . '　' . "{$this->first_name}";
    }
}
