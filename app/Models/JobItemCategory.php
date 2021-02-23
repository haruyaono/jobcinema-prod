<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobItemCategory extends Model
{
    protected $table = 'job_item_category';

    protected $fillable = [
        'job_item_id',
        'category_id',
        'ancestor_id',
        'ancestor_slug',
        'parent_id',
        'parent_slug',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}