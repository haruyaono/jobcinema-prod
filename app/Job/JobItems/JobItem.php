<?php

namespace App\Job\JobItems;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Job\Companies\Company;
use App\Job\Employers\Employer;
use App\Job\Users\User;
use App\Job\Applies\Apply;
use App\Job\Categories\Category;
use App\Traits\IsMobile;
use Illuminate\Support\Facades\Redis;

class JobItem extends Model
{
    use IsMobile; 

    protected $table = 'job_items';

    protected $guarded  = [];


    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'job_item_category')
                    ->withPivot([
                        'id',
                        'job_item_id',
                        'category_id',
                        'parent_id',
                        'slug',
                    ])->withTimeStamps();
    }
  

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function applies()
    {
        return $this->belongsToMany(Apply::class, 'apply_job_item')
                    ->withPivot([
                        'id',
                        'apply_id',
                        'job_item_id',
                        's_status',
                        'e_status',
                        'oiwaikin',
                        'oiwaikin_status',
                        'first_attendance',
                        'no_first_attendance'
                    ])->withTimeStamps();
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
            $value->year = (int)$year;
            $value->month = (int)$month;
            $value->year_month = sprintf("%04d年 %02d月", $year, $month);
        }
        return $month_list;
    }

    // public function checkApplication()
    // {
     
    //     // $this->jobitems->get;

    //     var_dump( $this->jobitems->);
    //         return \DB::table('apply_job_item')->where('apply_id', auth()->user()->id)->where('job_item_id', $this->id)->exists();
    // }


    public function scopeSearch($query, array $searchParams)
    {
        if (isset($searchParams['keyword'])) {
            $query->where(function($query) use ($searchParams){
                $query->where('job_title', 'like', "%${searchParams['keyword']}%")
                    ->orWhere('job_office', 'like', "%${searchParams['keyword']}%")
                    ->orWhere('job_desc', 'like', "%${searchParams['keyword']}%")
                    ->orWhere('job_intro', 'like', "%${searchParams['keyword']}%");
            });
        }
        foreach($searchParams as $key => $searchParam) {
            if($key == 'keyword' || $key == 'salary' || $key == 'ks' || $searchParam === null) {
                continue;
            }
            $query->whereHas('categories', function($builder) use ($searchParam) {

                    $builder->where('categories.id', $searchParam);
            });
        }

        if(isset($searchParams['ks'])) {
            $orderFlag = $searchParams['ks'];

            if(array_key_exists('c_id', $orderFlag) && $orderFlag['c_id'] != '') {
                $sub_query = DB::table('job_item_category')->whereRaw("parent_id = ".$orderFlag['c_id'])->toSql();

                $query->select('job_items.*', 'category.category_id', 'categories.name as category_name','category.parent_id')
                ->leftJoinSub($sub_query,'category', 'job_items.id', '=', 'category.job_item_id')
                ->leftJoin('categories', 'category.category_id', '=', 'categories.id');

                if(array_key_exists('order', $orderFlag) && $orderFlag['order'] != '') {
                    $query->orderBy('categories.name', $orderFlag['order']);
                } else {
                    $query->orderBy('categories.name', 'desc');
                }
            }

            if(array_key_exists('column', $orderFlag) && $orderFlag['column'] != '') {
                $query->orderBy("job_items.${orderFlag['column']}", 'desc');
            }
                
        }

    }

    public function favourites()
    {
            return $this->belongsToMany(JobItem::class, 'favourites', 'job_item_id', 'user_id')->as('fav')->withTimeStamps();
    }
    public function checkSaved()
    {
            return \DB::table('favourites')->where('user_id', auth()->user()->id)->where('job_item_id', $this->id)->exists();
    }

    
    public function img_judge()
    {
        $fnamebase = \Config::get('fpath.real_img').$this->id."/"."real.";
        
        if(file_exists(public_path().$fnamebase."gif")){
            return $fnamebase."gif";
        }else if(file_exists(public_path().$fnamebase."png")){
            return $fnamebase."png";
        }else if(file_exists(public_path().$fnamebase."jpg")){
            return $fnamebase."jpg";
        }else if(file_exists(public_path().$fnamebase."jpeg")){
            return $fnamebase."jpeg";
        }else{
            return \Config::get('fpath.noimage');
        }
    }

    public function scopeActiveJobitem()
    {
        $today = date("Y-m-d");
        $jobActive = JobItem::where('status', 2)
        ->where(function($query) use ($today){
          $query->orWhere('pub_end', '>', $today)
                ->orWhere('pub_end','無期限で掲載');
        })->where(function($query) use ($today){
          $query->orWhere('pub_start', '<', $today)
                ->orWhere('pub_start','最短で掲載');
        });

        return $jobActive;
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

    public function getRecommendJobList($jobItemId, $res)
    {
        $deviceFrag = $this->isMobile($res);
        switch ($deviceFrag) {
            case 'pc':
                $historyLimit = 4;
                break;
            case 'mobile':
                $historyLimit = -1;
                break;
            default:
                $historyLimit = 4;
                break;
        }
        
        return Redis::command('zRevRange', ['Jaccard:Item:' . $jobItemId, 0, $historyLimit]);
    }
}
