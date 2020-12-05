<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Company;
use App\Models\JobItem;
use App\Notifications\EmployerPasswordResetNotification;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Employer extends Authenticatable
{
    use Notifiable;

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
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmployerPasswordResetNotification($token));
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    /**
     * An employer can have many jobs.
     */
    public function jobitems(): HasManyThrough
    {
        return $this->hasManyThrough(JobItem::class, Company::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name}" . '　' . "{$this->first_name}";
    }

    public function isMainRegistered()
    {
        return  $this->status == 1 || $this->status == 8;
    }
}
