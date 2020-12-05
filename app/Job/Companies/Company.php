<?php

namespace App\Job\Companies;

use App\Job\Employers\Employer;
use App\Job\JobItems\JobItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function jobs(): HasMany
    {
        return $this->hasMany(JobItem::class, 'company_id');
    }

    public function employer(): belongsTo
    {
        return $this->belongsTo(Employer::class);
    }
}
