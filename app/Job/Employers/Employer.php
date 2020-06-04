<?php

namespace App\Job\Employers;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Company;
use App\Job\JobItems\JobItem;
use App\Notifications\EmployerPasswordResetNotification;
use App\Notifications\EmailVerificationJa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer extends Authenticatable
{
    use Notifiable, SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name','first_name','last_name_kana','first_name_kana', 'status',
        'phone1','phone2','phone3','email', 'password', 'email_verified', 'email_verify_token',
   ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
         'remember_token',
    ];

    protected $dates= ['deleted_at'];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
       $this->notify(new EmployerPasswordResetNotification($token));
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'employer_id');
    }
    public function jobs()
    {
        return $this->hasMany(JobItem::class);
    }

    public function isMainRegistered() { 
        return  $this->status == 1 || $this->status == 8;
    }
    
     

}
