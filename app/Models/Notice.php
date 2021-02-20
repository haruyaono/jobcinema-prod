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
        'delivered_at',
        'created_at',
        'updated_at',
    ];
}
