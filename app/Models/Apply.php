<?php

namespace App\Models;


use App\Models\User;
use App\Models\JobItem;
use App\Models\Company;
use App\Models\ApplyDetail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use  \Illuminate\Database\Eloquent\Relations\BelongsTo;
use  \Illuminate\Database\Eloquent\Relations\HasOne;

class Apply extends Model
{
    protected $table = 'applies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    protected $dates = [
        'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function jobitem(): BelongsTo
    {
        return $this->belongsTo(JobItem::class, 'job_item_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->jobitem->belongsTo(Company::class);
    }

    public function detail(): HasOne
    {
        return $this->hasOne(ApplyDetail::class);
    }

    public function getIsWithinHalfYearAttribute(): bool
    {
        $before6month = date("Y-m-d H:i:s", strtotime("-6 month"));
        return $this->created_at > $before6month;
    }

    public function getDaysLeftAttribute()
    {
        $day60AfterCreated = (new Carbon($this->created_at))->addDay(60);
        return Carbon::now()->diffInDays($day60AfterCreated, false);
    }


    public function getCongratsAmountAttribute($value)
    {
        return number_format($value) . "円";
    }

    public function getRecruitmentFeeAttribute($value)
    {
        return number_format($value) . "円(税別)";
    }

    public function getCreatedAtTransform(string $format)
    {
        return $this->created_at->format($format);
    }
}
