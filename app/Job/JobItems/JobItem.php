<?php

namespace App\Job\JobItems;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class JobItem extends Model
{
    protected $guarded  = [];


    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function status_cat_get()
    {
        return $this->belongsTo(\App\Job\Categories\StatusCategory::class, 'status_cat_id');
    }

    public function type_cat_get()
    {
        return $this->belongsTo(\App\Job\Categories\TypeCategory::class, 'type_cat_id');
    }

    public function area_cat_get()
    {
        return $this->belongsTo(\App\Job\Categories\AreaCategory::class, 'area_cat_id');
    }

    public function hourly_salary_cat_get()
    {
        return $this->belongsTo(\App\Job\Categories\HourlySalaryCategory::class, 'hourly_salary_cat_id');
    }

    public function date_cat_get()
    {
        return $this->belongsTo(\App\Job\Categories\DateCategory::class, 'date_cat_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function users()
    {
            return $this->belongsToMany(User::class)
            ->withPivot('id','user_id','last_name','first_name','postcode','prefecture','city','gender','age','phone1','phone2','phone3','occupation','final_education','work_start_date','job_msg','job_q1','job_q2','job_q3','s_status','e_status', 'oiwaikin', 'first_attendance', 'no_first_attendance', 'created_at')
            ->withTimeStamps();
    }

    public function getAppJobList(int $num_per_page = 10, array $condition = [])
    {
        // パラメータの取得
        $year  = array_get($condition, 'year');
        $month = array_get($condition, 'month');

        $query = DB::table('job_item_user')->orderBy('created_at', 'desc');

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
            // Where句を追加
            $query->where('created_at', '>=', $start_date->format('Y-m-d'))
                  ->where('created_at', '<',  $end_date->format('Y-m-d'));
        }

        // paginate メソッドを使うと、ページネーションに必要な全件数やオフセットの指定などは全部やってくれる
        return $query->paginate($num_per_page);
    }

    public function getMonthList()
    {
        // selectRaw メソッドを使うと、引数にSELECT文の中身を書いてそのまま実行できる
        // 返り値はコレクション（Illuminate\Database\Eloquent\Collection Object）
        // コレクションとは配列データを操作するための便利なラッパーで、多種多様なメソッドが用意されている
        $month_list = DB::table('job_item_user')
            ->selectRaw('substring(created_at, 1, 7) AS year_and_month')
            ->groupBy('year_and_month')
            ->orderBy('year_and_month', 'desc')
            ->get();

        foreach ($month_list as $value) {
            // YYYY-MM をハイフンで分解して、YYYY年MM月という表記を作る
            list($year, $month) = explode('-', $value->year_and_month);
            $value->year  = $year;
            $value->month = (int)$month;
            $value->year_month = sprintf("%04d年 %02d月", $year, $month);
        }
        return $month_list;
    }

    public function checkApplication()
    {
            return \DB::table('job_item_user')->where('user_id', auth()->user()->id)->where('job_item_id', $this->id)->exists();
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
}
