<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoticeRead extends Model
{
    protected $table = 'notice_read';

    protected $fillable = [
        'notice_id',
        'company_id',
        'user_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function notice(): BelongsTo {
        return $this->belongsTo(Notice::class);
    }
}
