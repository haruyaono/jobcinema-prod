<?php

namespace App\Models;

use App\Models\JobItem;
use App\Models\AchievementReward;
use App\Models\CongratsMoney;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use NodeTrait;

    protected $table = 'categories';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    public function jobitems(): BelongsToMany
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

    public function achievementReward(): HasOne
    {
        return $this->hasOne(AchievementReward::class);
    }

    public function congratsMoney(): HasOne
    {
        return $this->hasOne(CongratsMoney::class);
    }
}
