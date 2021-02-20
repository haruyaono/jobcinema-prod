<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdItem extends Model
{
    protected $table = 'ad_items';

    protected $fillable = [
        'company_id',
        'job_item_id',
        'image_path',
        'description',
        'price',
        'is_view',
        'started_at',
        'ended_at',
    ];

    protected $dates = [
        'started_at',
        'ended_at',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function jobItem(): BelongsTo
    {
        return $this->belongsTo(JobItem::class);
    }
}
