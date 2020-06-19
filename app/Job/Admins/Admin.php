<?php

namespace App\Job\Admins;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password',
    ];
 
    protected $hidden = [
        'password', 'remember_token',
    ];
}
