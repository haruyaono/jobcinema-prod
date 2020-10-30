<?php

namespace App\Job\Applies;


use App\Job\Users\User;
use App\Job\JobItems\JobItem;
use App\Job\Companies\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use  \Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function getIsWithinHalfYearAttribute(): bool
    {
        $before6month = date("Y-m-d H:i:s", strtotime("-6 month"));
        return $this->created_at > $before6month;
    }

    public function getCongratsAmountAttribute($value)
    {
        return number_format($value) . "円";
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
