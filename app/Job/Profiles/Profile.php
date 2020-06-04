<?php

namespace App\Job\Profiles;

use App\Job\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use softDeletes; 

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

    protected $dates= ['deleted_at'];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

}
