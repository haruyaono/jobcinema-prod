<?php

namespace App\Job\Employers;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Job\Companies\Company;
use App\Job\JobItems\JobItem;
use App\Notifications\EmployerPasswordResetNotification;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
        'last_name', 'first_name', 'last_name_kana', 'first_name_kana', 'status',
        'phone1', 'phone2', 'phone3', 'email', 'password', 'email_verified', 'email_verify_token',
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

    protected $dates = ['deleted_at'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmployerPasswordResetNotification($token));
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'employer_id');
    }

    /**
     * An employer can have many jobs.
     */
    public function jobitems(): HasManyThrough
    {
        return $this->hasManyThrough(JobItem::class, Company::class);
    }

    public function isMainRegistered()
    {
        return  $this->status == 1 || $this->status == 8;
    }
}
