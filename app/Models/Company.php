<?php

namespace App\Models;

use App\Models\AdItem;
use App\Models\Employer;
use App\Models\JobItem;
use App\Traits\ExtendExplode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use ExtendExplode;

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

    public function readNotice(): HasMany {
        return $this->hasMany(NoticeRead::class, 'company_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(JobItem::class, 'company_id');
    }

    public function ads(): HasMany
    {
        return $this->hasMany(AdItem::class, 'company_id');
    }

    public function employer(): belongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function getListPostcodeAttribute()
    {
        return "{$this->postcode}" ? explode("-", "{$this->postcode}") : [];
    }

    public function getFullPhoneAttribute()
    {
        return "{$this->phone1}" . '-' . "{$this->phone2}" . '-' . "{$this->phone3}";
    }

    public function getListFoundationAttribute()
    {
        $list = "{$this->foundation}" ? $this->double_explode('年', '月', "{$this->foundation}") : [];
        return array_map(function ($value) {
            return (int) trim($value);
        }, $list);
    }
}
