<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\JobItem;
use App\Models\User;
use App\Models\Company;
use App\Models\Employer;
use App\Models\StatusCat;
use App\Models\TypeCat; 
use App\Models\AreaCat; 
use App\Models\HourlySalaryCat; 
use App\Models\DateCat; 
use App\Http\Requests\bellingParameter;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobAdopt;
use App\Mail\JobUnAdopt;
use DB;
use File; 

class DashboardController extends Controller
{


    protected $jobitem;

    // 1ページ当たりの表示件数
    const NUM_PER_PAGE = 10;

    function __construct(JobItem $jobitem)
    {
        $this->middleware(['admin']);
        $this->jobitem = $jobitem;
    }

    public function getAllJobs()
    {
        $jobs = JobItem::latest()->paginate(10);
        $sortBy1 = "";
        $sortBy2 = "";
      
        return view('admin.alljob', compact('jobs', 'sortBy1', 'sortBy2'));
    }

    public function jobsSort(Request $request)
    {
        $query = JobItem::query();
        switch($request->job_status){
            case 'createLate':
                $query = $query->latest('created_at');
                break;
            case 'createOld':
                $query = $query->oldest('created_at');
                break;
            case 'status_1':
                $query = $query->where('status', 1)->latest();
                break;
            case 'status_5':
                $query = $query->where('status', 5)->latest();
                break;
            case 'status_6':
            $query = $query->where('status', 6)->latest();
            break;
            default:
                $query = $query->latest('id');
                break;
        }

        switch($request->oiwaikin_status){
            case 'oiwaikin_true':
                $query = $query->whereNotNull('oiwaikin')->latest();
                break;
            case 'oiwaikin_false':
            $query = $query->whereNull('oiwaikin')->latest();
                break;
            default:
                break;
        }
      
        $query = $query->paginate(10);
        $jobs = $query;

        if( Input::get('page') > $jobs->LastPage()) {
            abort(404);
        }

        return view('admin.alljob', compact('jobs'))
                ->with('sortBy1', $request->job_status)
                ->with('sortBy2', $request->oiwaikin_status);
    }



    public function getJobDetail($id)
    {
        $job = JobItem::find($id);
      
        return view('admin.job_detail', compact('job'));
    }

    public function oiwaikinChange($id)
    {
        $job = JobItem::find($id);
        if(!$job->oiwaikin) {
            $job->oiwaikin = 2000;
        } else {
            $job->oiwaikin = null;
        }
        $job->save();

        return redirect()->back()->with('message','お祝い金設定を変更しました');
    }

    public function getApprovalPendingJobs()
    {
        $jobs = JobItem::where('status', 1)->latest()->paginate(10);
        return view('admin.approval_pending_job', compact('jobs'));
    }

    public function approeJobStatus($id)
    {
        $job = JobItem::find($id);
        $job->status = 2;
        $job->save();

        $employer = $job->employer;

        $email = new JobAdopt($employer, $job);
        Mail::to($employer->email)->queue($email);

        return redirect()->back()->with('message','承認しました');
    }
    public function nonApproeJobStatus($id)
    {
        $job = JobItem::find($id);
        $job->status = 3;
        $job->save();
        $employer = $job->employer;

        $email = new JobUnAdopt($employer, $job);
        Mail::to($employer->email)->queue($email);

        return redirect()->back()->with('message','非承認にしました');
    }

    public function nonPublicJobStatus($id)
    {
        $job = JobItem::find($id);
        $job->status = 6;
        $job->save();

        return redirect()->back()->with('message','完全非公開にしました');
    }

    public function jobDetete($id)
    {
        $job = JobItem::find($id);

        DB::beginTransaction();
        try {

            File::delete([
                public_path().$job->job_img, 
                public_path().$job->job_img2, 
                public_path().$job->job_img3,
                public_path().$job->job_mov, 
                public_path().$job->job_mov2, 
                public_path().$job->job_mov3,
            ]);
            \File::deleteDirectory(public_path() . \Config::get('fpath.real_img') . $job->id);
            \File::deleteDirectory(public_path() . \Config::get('fpath.real_mov') . $job->id);

            if($job->users()->exists()) {
                $job->users()->detach();
            }
            if(DB::table('favourites')->where('job_item_id', $job->id)->exists()) {
                DB::table('favourites')->where('job_item_id', $job->id)->delete();
            }

            $job->delete();

            DB::commit();

        } catch (\Exception $e) {
           
            DB::rollback();
        }
    
        return redirect()->back()->with('message','削除しました');
    }

    public function getAppManage()
    {
        $app_list = DB::table('job_item_user')->latest()->paginate(10);
      
        return view('admin.app_list', compact('app_list'));
    }

    public function getOiwaikinUsers()
    {
        $oiwaikin_users = DB::table('job_item_user')->whereNotNull('oiwaikin')->whereNotNull('first_attendance')->latest()->paginate(10);
      
        return view('admin.oiwaikin_users', compact('oiwaikin_users'));
    }
    
    public function getUserDetail($id)
    {
        $app_info = DB::table('job_item_user')->where('id', $id)->first();
     
        $job_info = JobItem::where('id',$app_info->job_item_id)->first();
        $user_info = User::where('id', $app_info->user_id)->first();
        return view('admin.user_detail', compact('app_info', 'job_info', 'user_info'));
    }

    public function getBilling()
    {
        $month_list = $this->jobitem->getMonthList();
        $job_list = JobItem::has('users')->get();
        $companies = [];
        
        foreach($job_list as $job_item) {
            $company = Company::where('employer_id', $job_item->employer_id)->first();
            array_push($companies, $company);
        }
        return view('admin.billing_top', compact('month_list', 'companies'));
    }

    public function getBillingYear(bellingParameter $request)
    {
        $input = $request->input();
        

        // ブログ記事一覧を取得
        $app_list = $this->jobitem->getAppJobList(self::NUM_PER_PAGE, $input);


        // ページネーションリンクにクエリストリングを付け加える
        $app_list->appends($input);
        $month_list = $this->jobitem->getMonthList()->where('year', $input['year'])->where('month', $input['month'])->first();

        $total = $app_list->count() * 30000;
        $total = number_format($total);
    
        return view('admin.billing_year', compact('app_list', 'month_list', 'total'));
    }

    public function getAllCompanies()
    {
        $companies = Company::latest()->paginate(10);
        $sortBy1 = "";
      
        return view('admin.all_company', compact('companies', 'sortBy1'));
    }

    public function companiesSort(Request $request)
    {
        $companies = Company::whereHas('employer', function($query) use ($request) {
            switch($request->company_status){
                case 'status_8':
                    $query->where('status', 8)->latest();
                    break;
                default:
                    $query->latest('companies.created_at');
                    break;
            }

        })->paginate(10);

        if( Input::get('page') > $companies->LastPage()) {
            abort(404);
        }

        return view('admin.all_company', compact('companies'))
                ->with('sortBy1', $request->company_status);
    }

    public function getCompanyDetail($id)
    {
        $company = Company::find($id);
        
        $jobs =  $company->jobs;
       
        return view('admin.company_detail', compact('company', 'jobs'));
    }

    public function employerDelete($id)
    {
        $employer = Employer::find($id);

        DB::beginTransaction();
        try {

            if(!$employer->jobs->isEmpty()) {

                $jobs = $employer->jobs->where('employer_id', $employer->id);

                foreach($jobs as $job) {
                    File::delete([
                        public_path().$job->job_img, 
                        public_path().$job->job_img2, 
                        public_path().$job->job_img3,
                        public_path().$job->job_mov, 
                        public_path().$job->job_mov2, 
                        public_path().$job->job_mov3,
                    ]);
                    \File::deleteDirectory(public_path() . \Config::get('fpath.real_img') . $job->id);
                    \File::deleteDirectory(public_path() . \Config::get('fpath.real_mov') . $job->id);

                    if($job->users()->exists()) {
                        $job->users()->detach();
                    }
                    if(DB::table('favourites')->where('job_item_id', $job->id)->exists()) {
                        DB::table('favourites')->where('job_item_id', $job->id)->delete();
                    }

                    $job->delete();

                }

            }

            Company::where('employer_id', $employer->id)->delete();
            $employer->delete();

            DB::commit();

        } catch (\Exception $e) {
           
            DB::rollback();
        }
       
        return redirect()->back()->with('message', 'アカウントを削除しました');

    }

    public function categoryTop()
    {
        return view('admin.category_top');
    }
    
    public function category($url)
    {
        if($url == 'status') {
            $catList = StatusCat::paginate(self::NUM_PER_PAGE);
            $catTitle = '雇用形態';
        } elseif($url == 'type') {
            $catList = TypeCat::paginate(self::NUM_PER_PAGE);
            $catTitle = '職種';
        } elseif($url == 'area') {
            $catList = AreaCat::paginate(self::NUM_PER_PAGE);
            $catTitle = 'エリア';
        } elseif($url == 'hourly_salary') {
            $catList = HourlySalaryCat::paginate(self::NUM_PER_PAGE);
            $catTitle = '時給';
        } elseif($url == 'date') {
            $catList = DateCat::paginate(self::NUM_PER_PAGE);
            $catTitle = '勤務日数';
        } else {
        }
        
        
        return view('admin.category', compact('catList','url', 'catTitle'));
    }


     /**
     * カテゴリ編集・新規作成API
     *
     * @param AdminRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCategory(AdminRequest $request, $flag)
    {
        $input = $request->input();
        $category_id = $request->input('category_id');
        if($flag == 'status') {
            $category = StatusCat::updateOrCreate(compact('id'), $input);
        } elseif($flag == 'type') {
            $category = TypeCat::updateOrCreate(compact('id'), $input);
        } elseif($flag == 'area') {
            $category = AreaCat::updateOrCreate(compact('id'), $input);
        } elseif($flag == 'hourly_salary') {
            $category = HourlySalaryCat::updateOrCreate(compact('id'), $input);
        } elseif($flag == 'date') {
            $category = DateCat::updateOrCreate(compact('id'), $input);
        } else {
            $category = '';
        }

        // // APIなので json のレスポンスを返す
        return response()->json($category);
    }

    /**
     * カテゴリ削除API
     *
     * @param AdminRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCategory(AdminRequest $request, $flag)
    {
        $category_id = $request->input('category_id');
        if($flag == 'status') {
            StatusCat::destroy($category_id);
        } elseif($flag == 'type') {
            TypeCat::destroy($category_id);
        } elseif($flag == 'area') {
            AreaCat::destroy($category_id);
        } elseif($flag == 'hourly_salary') {
            HourlySalaryCat::destroy($category_id);
        } elseif($flag == 'date') {
            DateCat::destroy($category_id);
        } 

        // APIなので json のレスポンスを返す
        return response()->json();
    }


}
