<?php

namespace App\Job\Companies;

use App\Job\Employers\Employer;
use App\Job\JobItems\JobItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
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

    public function jobs()
    {
        return $this->hasMany(JobItem::class, 'company_id');
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

}
