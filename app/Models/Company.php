<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Job\JobItems\JobItem;

class Company extends Model
{
    protected $fillable = [
        'cname','cname_kana', 'employer_id', 'slug',
        'postcode','prefecture','address', 'phone1', 'phone2', 'phone3', 'website',
        'logo', 'cover_photo', 'slogan','industry',
        'description', 'foundation', 'ceo',
        'capital', 'employee_number',
      ];
    
    public function getRouteKeyName() 
    {
        return 'slug';
    }

    public function jobs()
    {
        return $this->hasMany(\App\Job\JobItems\JobItem::class, 'company_id');
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

}
