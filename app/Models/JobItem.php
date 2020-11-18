<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Employer;
use App\Models\Company;
use App\Models\Apply;
use App\Models\Category;
use App\Traits\IsMobile;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobItem extends Model
{
    use IsMobile;

    protected $table = 'job_items';

    protected $guarded  = [];

    protected $dates = [
        'pub_start_date',
        'pub_end_date',
        'created_at',
        'updated_at',
    ];

    /**
     * get public start date
     *
     * @return string
     */
    public function getStartDateAttribute()
    {
        if ($this->pub_start_flag === 0 && $this->pub_start_date === null) {
            return "最短で掲載";
        } else {
            return "{$this->pub_start_date}" >= 0 ? "{$this->pub_start_date->format('Y年m月d日')}" : "{$this->pub_start_date}";
        }
    }

    /**
     * get public end date
     *
     * @return string
     */
    public function getEndDateAttribute()
    {
        if ($this->pub_end_flag === 0 && $this->pub_end_date === null) {
            return "無期限で掲載";
        } else {
            return  "{$this->pub_end_date}" >= 0 ? "{$this->pub_end_date->format('Y年m月d日')}" : "{$this->pub_end_date}";
        }
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'job_item_category')
            ->withPivot([
                'id',
                'job_item_id',
                'category_id',
                'ancestor_id',
                'parent_id',
                'ancestor_slug',
                'parent_slug',
            ])->withTimeStamps();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function employer(): BelongsTo
    {
        return $this->company->belongsTo(Employer::class);
    }

    public function applies(): HasMany
    {
        return $this->hasMany(Apply::class);
    }

    public function existsCongratsMoney()
    {
        return $this->categories()->wherePivot('ancestor_slug', 'status')->first()->congratsMoney()->exists();
    }

    public function getCongratsMoney()
    {
        return  $this->categories()->wherePivot('ancestor_slug', 'status')->first()->congratsMoney;
    }

    public function getAchivementRewardMoneyAmount()
    {
        $category = $this->categories()->wherePivot('ancestor_slug', 'status')->first();
        return $category->achievementReward()->exists() ? $category->achievementReward->amount : 0;
    }

    public function getAppJobList(int $num_per_page = 10, array $condition = [])
    {
        // パラメータの取得
        $year  = array_get($condition, 'year');
        $month = array_get($condition, 'month');

        $query = DB::table('apply_job_item')->orderBy('created_at', 'desc');
        // 期間の指定
        if ($year) {
            if ($month) {
                // 月の指定がある場合はその月の1日を設定し、Carbonインスタンスを生成
                $start_date = Carbon::createFromDate($year, $month, 1);
                $end_date   = Carbon::createFromDate($year, $month, 1)->addMonth();     // 1ヶ月後
            } else {
                // 月の指定が無い場合は1月1日に設定し、Carbonインスタンスを生成
                $start_date = Carbon::createFromDate($year, 1, 1);
                $end_date   = Carbon::createFromDate($year, 1, 1)->addYear();           // 1年後
            }

            $query->where('created_at', '>=', $start_date->format('Y-m-d'))
                ->where('created_at', '<',  $end_date->format('Y-m-d'));
        }

        return $query->paginate($num_per_page);
    }

    public function getMonthList()
    {
        $month_list = DB::table('apply_job_item')
            ->selectRaw('substring(created_at, 1, 7) AS year_and_month')
            ->groupBy('year_and_month')
            ->orderBy('year_and_month', 'desc')
            ->get();

        foreach ($month_list as $value) {
            // YYYY-MM をハイフンで分解して、YYYY年MM月という表記を作る
            list($year, $month) = explode('-', $value->year_and_month);
            $value->year = (int) $year;
            $value->month = (int) $month;
            $value->year_month = sprintf("%04d年 %02d月", $year, $month);
        }
        return $month_list;
    }

    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favourites', 'job_item_id', 'user_id')->as('fav')->withTimeStamps();
    }

    public function checkSaved()
    {
        return \DB::table('favourites')->where('user_id', auth('seeker')->user()->id)->where('job_item_id', $this->id)->exists();
    }

    public function scopeActiveJobitem()
    {
        $today = date("Y-m-d");
        $jobitems = JobItem::where('status', 2)
            ->where(function ($query) use ($today) {
                $query->orWhere('pub_end_date', '>=', $today)
                    ->orWhere('pub_end_flag', 0);
            })->where(function ($query) use ($today) {
                $query->orWhere('pub_start_date', '<=', $today)
                    ->orWhere('pub_start_flag', 0);
            });

        return $jobitems;
    }

    public function scopeAcriveForEmpJobitems($query)
    {
        return $query->whereNotIn('status', [8, 9, 99]);
    }

    public function calcRecommend()
    {
        $job_ids = $this->ActiveJobitem()->pluck('id')->toArray();
        $job_ids = array_flatten($job_ids);

        foreach ($job_ids as $job_id1) {
            $base = Redis::command('lRange', ['Viewer:Item:' . $job_id1, 0, 999]);

            if (count($base) === 0) {
                continue;
            }

            foreach ($job_ids as $job_id2) {
                if ($job_id1 === $job_id2) {
                    continue;
                }

                $target = Redis::command('lRange', ['Viewer:Item:' . $job_id2, 0, 999]);
                if (count($target) === 0) {
                    continue;
                }

                # ジャッカード指数を計算
                $join = floatval(count(array_unique(array_merge($base, $target))));
                $intersect = floatval(count(array_intersect($base, $target)));
                if ($intersect == 0 || $join == 0) {
                    continue;
                }
                $jaccard = $intersect / $join;


                Redis::command('zAdd', ['Jaccard:Item:' . $job_id1, $jaccard, $job_id2]);
            }
        }
    }

    public function getRecommendJobList($id)
    {
        $max = 4;
        return Redis::command('zRevRange', ['Jaccard:Item:' . $id, 0, $max]);
    }
}
