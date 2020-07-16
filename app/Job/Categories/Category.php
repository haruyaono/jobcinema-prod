<?php

namespace App\Job\Categories;

use App\Job\JobItems\JobItem;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    protected $table = 'categories';
    protected $fillable = ['name', 'slug'];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobitems()
    {
        return $this->belongsToMany(JobItem::class, 'job_item_category')
                    ->withPivot([
                        'id',
                        'job_item_id',
                        'category_id',
                        'parent_id',
                    ])->withTimeStamps();
    }

    public function getNameList(array $idList)
    {
        return $this->find($idList)->pluck('name');
    }
}
