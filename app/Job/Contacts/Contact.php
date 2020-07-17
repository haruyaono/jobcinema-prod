<?php

namespace App\Job\Contacts;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'division',
        'category',
        'name',
        'name_ruby',
        'c_name',
        'c_name_ruby',
        'email',
        'phone',
        'content',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

}
