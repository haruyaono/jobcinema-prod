<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notice';

    protected $fillable = [
        'subject',
        'content',
        'target',
        'is_delivered',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
