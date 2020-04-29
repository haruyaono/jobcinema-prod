<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Job\JobItems\JobItem;
use App\Models\Profile;
use App\Models\PostalCode;
use App\Models\Company;
use App\Job\Categories\StatusCategory;
use App\Job\Categories\TypeCategory;
use App\Job\Categories\HourlySalaryCategory;
use App\Job\Categories\AreaCategory;
use App\Job\Categories\DateCategory;
use App\Http\Requests\JobCreateStep1Request;
use App\Http\Requests\JobCreateStep2Request;
use App\Http\Requests\JobCreateTmpSaveRequest;
use App\Mail\JobAppliedSeeker;
use App\Mail\JobAppliedEmployer;
use Illuminate\Support\Facades\Mail;
use File;
use Storage;
use Auth;
use DB;

use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;


class JobController extends Controller

{

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;
    private $job_form_session = 'count';
    
  

     /**
     * JobController constructor.
     * @param JobItem $JobItem
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(JobItem $JobItem, CategoryRepositoryInterface $categoryRepository)
    {
      $this->middleware(['employer'], ['except'=>array('index','show', 'postJobHistory', 'getApplyStep1','postApplyStep1','getApplyStep2','postApplyStep2', 'completeJobApply', 'allJobs', 'realSearchJob')]);

      $this->JobItem = $JobItem;
      $this->categoryRepo = $categoryRepository;
    }

    public function index()
    {
      $jobs_models = $this->JobItem->activeJobitem();
      $jobs = $jobs_models->get();
      // $allCategory = $this->categoryRepo->allCategories();
      // dd($allCategory[0]->get());
      $topLimitJobs = $jobs_models->latest()->limit(3)->get();

      return view('jobs.index', compact('jobs','topLimitJobs'));
    }

    public function show($id)
    {
      session()->forget('jobapp_count');
      session()->forget('jobapp_data');
      

      $job = JobItem::find($id);

      if(session()->has('recent_jobs') && is_array(session()->get('recent_jobs'))) {
        
        $jobitem_id_list = session()->get('recent_jobs');
        
        if(in_array($id, $jobitem_id_list) == false ) {
          session()->push('recent_jobs', $id);
        } 
        
      } else {
        session()->push('recent_jobs', $id);
      }
    
      if($job->status == 2) {
        $title = $job->company->cname;
        return view('jobs.show', compact('job', 'title'));
      } else {
        if($jobitem_id_list && in_array($id, $jobitem_id_list) ) {
          $index = array_search( $id, $jobitem_id_list, true );
          session()->forget("recent_jobs.$index");
        } 
      }

      

      return redirect()->to('/');


    }

    // 最近見た求人
    public function postJobHistory(Request $request) {
      if($request->session()->has('recent_jobs') && is_array($request->session()->get('recent_jobs'))) {
        $jobitem_id_list = $request->session()->get('recent_jobs');
      } else {
        $jobitem_id_list = [];
      }
      $recent_jobitems = JobItem::find($jobitem_id_list);
      return response()->json($recent_jobitems);
    }


    public function applicant()
    {
      $applicants = JobItem::has('users')->where('employer_id', Auth::guard('employer')->user()->id)->get();
      return view('jobs.applicants', compact('applicants'));
    }
    
    public function applicantDetail($id, $user_id)
    {
      $job = JobItem::has('users')->findOrFail($id);
      $applicantUser = User::findOrFail($user_id);
      $applicantUserInfo = $job->users()->where('user_id', $applicantUser->id)->first();

      return view('jobs.applicants_detail', compact('job', 'applicantUser', 'applicantUserInfo'));
    }

    public function empAdoptJob($id, $user_id)
    {
        $jobid = JobItem::findOrFail($id);
        $appJob = DB::table('job_item_user')
            ->where('user_id', $user_id)
            ->where('job_item_id', $jobid->id)
            ->update([
                'e_status' => 1,
            ]);
        session()->flash('flash_message_success', '採用通知しました！');
        return redirect()->to('jobs/applications');
    }
    public function empUnAdoptJob($id, $user_id)
    {
        $jobid = JobItem::findOrFail($id);
        $appJob = DB::table('job_item_user')
            ->where('user_id', $user_id)
            ->where('job_item_id', $jobid->id)
            ->update([
                'e_status' => 2,
            ]);
        session()->flash('flash_message_success', '採用通知しました！');
        return redirect()->to('jobs/applications');
    }
    public function empAdoptCancelJob($id, $user_id)
    {
        $jobid = JobItem::findOrFail($id);
        $appJob = DB::table('job_item_user')
            ->where('user_id', $user_id)
            ->where('job_item_id', $jobid->id)
            ->update([
                'e_status' => 0,
            ]);
        session()->flash('flash_message_success', '採用を取り消しました！');
        return redirect()->to('jobs/applications');
    }

    public function myJob()
    {
      $jobs = JobItem::where('employer_id', auth('employer')->user()->id)->latest()->paginate(10);
      //件数表示の例外処理
      if( Input::get('page') > $jobs->LastPage()) {
        abort(404);
      }

      

      $employer_id = auth('employer')->user()->id;
      $job_list = JobItem::where('employer_id', $employer_id)->get(['job_img', 'job_img2', 'job_img3']);
      $job_list_2 = JobItem::where('employer_id', $employer_id)->get(['job_mov', 'job_mov', 'job_mov3']);

      $job_image_list = array_diff(array_flatten($job_list->toArray()), array(null));
      $job_movie_list = array_diff(array_flatten($job_list_2->toArray()), array(null));

      // image session
      if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))){

        $image_path_list = session()->get('data.file.image');
        foreach($image_path_list as $index => $image_path) {

          if(File::exists(public_path() . $image_path)) {
            File::delete(public_path() . $image_path);
          }

        }

        session()->forget('data.file.image');

      }

      if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image')))
      {
        $edit_image_path_list = session()->get('data.file.edit_image');

        foreach($edit_image_path_list as $index => $image_path) {
          if($index == 'main' || $index == 'sub1' || $index == 'sub2' and $image_path != '')  {

            if(in_array($image_path, $job_image_list) == false && File::exists(public_path() . $image_path)) {
              File::delete(public_path() . $image_path);
            }

          }
        }

        session()->forget('data.file.edit_image');

      }


      // movie Yaf_Session
      if(session()->has('data.file.movie') && is_array(session()->get('data.file.movie'))){

        $movie_path_list = session()->get('data.file.movie');
        foreach($movie_path_list as $index => $movie_path) {

          if(File::exists(public_path() . $movie_path)) {
            File::delete(public_path() . $movie_path);
          }

        }
        session()->forget('data.file.movie');
      }

      if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie')))
      {
        $edit_movie_path_list = session()->get('data.file.edit_movie');

        foreach($edit_movie_path_list as $index => $movie_path) {
          if($index == 'main' || $index == 'sub1' || $index == 'sub2' and $movie_path != '')  {

            if(in_array($movie_path, $job_movie_list) == false && File::exists(public_path() . $movie_path)) {
              File::delete(public_path() . $movie_path);
            }

          }
        }

        session()->forget('data.file.edit_movie');

      }


      return view('jobs.myjob', compact('jobs'));
    }

    public function edit($id)
    {

      echo '<pre>';
      var_dump(session()->get('data.file'));
      echo '</pre>';
      
      try{
        session()->put('count', 1);

        // 新規作成時のファイル用セッションが残っていたら削除
        if(session()->has('data.file.image')) {
          session()->forget('data.file.image');
        }
        if(session()->has('data.file.movie')) {
          session()->forget('data.file.movie');
        }
        $job = JobItem::findOrFail($id);

       

      } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){

        return redirect()->route('my.job')->with('message_alert', '該当する求人票が見つかりません。');

      }

      return view('jobs.post.edit', compact('job'));
      
    }

    public function catEdit($id, $category)
    {
      $job = JobItem::findOrFail($id);

      return view('jobs.post.cat_edit', compact('job', 'category'));
    }

    public function catUpdate(Request $request, $id)
    {
      $job = JobItem::findOrFail($id);

      if(session()->has('data.form.edit_category')){
        $edit_cat_list = session()->get('data.form.edit_category');
      }


      if($request->input('cat_flag') == 'status') {

        $edit_cat_list['status'] = $request->input('status_cat_id');
        $request->session()->put('data.form.edit_category', $edit_cat_list);

      } elseif($request->input('cat_flag') == 'type') {

        $edit_cat_list['type'] = $request->input('type_cat_id');
        $request->session()->put('data.form.edit_category', $edit_cat_list);

      } elseif($request->input('cat_flag') == 'area') {

        $edit_cat_list['area'] = $request->input('area_cat_id');
        $request->session()->put('data.form.edit_category', $edit_cat_list);

      } elseif($request->input('cat_flag') == 'hourly_salary') {

        $edit_cat_list['hourly_salary'] = $request->input('hourly_salary_cat_id');
        $request->session()->put('data.form.edit_category', $edit_cat_list);

      } elseif($request->input('cat_flag') == 'date') {

        $edit_cat_list['date'] = $request->input('date_cat_id');
        $request->session()->put('data.form.edit_category', $edit_cat_list);

      }

      return redirect()->route('job.edit', [$job->id]);
    }


    

    public function createTop()
    {

      $employer_id = auth('employer')->user()->id;
      $job_list = JobItem::where('employer_id', $employer_id)->get(['job_img', 'job_img2', 'job_img3']);
      $job_list_2 = JobItem::where('employer_id', $employer_id)->get(['job_mov', 'job_mov2', 'job_mov3']);

      $job_image_list = array_diff(array_flatten($job_list->toArray()), array(null));
      $job_movie_list = array_diff(array_flatten($job_list_2->toArray()), array(null));

     

      // image session

      if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))){

        $image_path_list = session()->get('data.file.image');
        foreach($image_path_list as $index => $image_path) {

          if(File::exists(public_path() . $image_path)) {
            File::delete(public_path() . $image_path);
          }

        }
      }

      if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image'))) {
        $edit_image_path_list = session()->get('data.file.edit_image');

        foreach($edit_image_path_list as $index => $image_path) {
          if($index == 'main' || $index == 'sub1' || $index == 'sub2' and $image_path != '')  {

            if(in_array($image_path, $job_image_list) == false && File::exists(public_path() . $image_path)) {
              File::delete(public_path() . $image_path);
            }

          }
        }

      }

      // movie sessoin
      if(session()->has('data.file.movie') && is_array(session()->get('data.file.movie'))){

        $movie_path_list = session()->get('data.file.movie');
        foreach($movie_path_list as $index => $movie_path) {

          if(File::exists(public_path() . $movie_path)) {
            File::delete(public_path() . $movie_path);
          }

        }
 
      }

      if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie'))) {
        $edit_movie_path_list = session()->get('ata.file.edit_movie');

        foreach($edit_movie_path_list as $index => $movie_path) {
          if($index == 'main' || $index == 'sub1' || $index == 'sub2' and $movie_path != '')  {

            if(in_array($movie_path, $job_movie_list) == false && File::exists(public_path() . $movie_path)) {
              File::delete(public_path() . $movie_path);
            }

          }
        }

      }
      
      session()->forget('data');
      session()->forget('count');

      return view('jobs.post.top_create');

    }

    public function createStep1()
    {
      if (preg_match("/iPhone|iPod|Android.*Mobile|Windows.*Phone/", $_SERVER['HTTP_USER_AGENT'])) {
        return view('jobs.post.create_step1_sp');
      } else {
        return view('jobs.post.create_step1');
      }

    }
    public function createStep2()
    {
     
      echo '<pre>';
      var_dump(session()->get('data.file'));
      echo '</pre>';

      if(session()->has('count') == 1 || session()->has('count') == 3) {

        session()->forget('data.file.edit_image');
        session()->forget('data.file.edit_movie');

        return view('jobs.post.create_step2', compact('jobItem'));

      } else {

        session()->forget('count');

        return redirect()->to('/jobs/create/step1');

      }

    }

    public function storeStep1 (JobCreateStep1Request $request)
    {

      $request->session()->put('data.form.category', $request->all());
      $request->session()->put('count', 1);

      return redirect()->route('job.create.step2');
    }

    public function draftOrStep2(Request $request, $id=''){
      if (Input::get('draft')){
        // 一時保存

        if (JobItem::where('id',$id)->exists()) {
          // edit

          $this->draft($request, $id);

          return view('jobs.post.create_tmp_complete');

        } else {
          // 新規作成時

          $this->draft($request);

          return view('jobs.post.create_tmp_complete');

        }

      } elseif (Input::get('storestep2')){

          if ( JobItem::where('id',$id)->exists() == false ) {
            if(session()->has('data.file.image.main')==false){
              return redirect()->back()->with('message','メイン画像を登録してください');
            };
            $this->storeStep2($request);
            return redirect()->to('/jobs/create/confirm');

          } else {
            $job = JobItem::findOrFail($id);

            if(session()->has('data.file.edit_image.main')==false ){

              if($job->job_img == null) {
                return redirect()->back()->with('message_danger','メイン画像を登録してください');
              }

            } elseif(session()->has('data.file.edit_image.main')==true && session()->get('data.file.edit_image.main')=="") {
              return redirect()->back()->with('message_danger','メイン画像を登録してください');
            };


            $this->storeStep2($request, $id);

            return redirect()->action('JobController@createConfirm', ['id' => $id]);

          }

      }

    }

    public function draft(Request $request, $id='')
    {
      $this->validate($request,[
            'job_title' => 'nullable|max:30',
            'job_intro' => 'nullable|max:250',
            'job_img' => 'nullable',
            'job_office' => 'nullable|max:191',
            'job_office_address' => 'nullable|max:191',
            'job_type' => 'nullable|max:191',
            'job_desc' => 'nullable|max:700',
            'job_hourly_salary' => 'nullable|max:191',
            'salary_increase' => 'nullable|max:191',
            'job_target' => 'nullable|max:400',
            'job_time' => 'nullable|max:400',
            'job_treatment' => 'nullable|max:400',
            'remarks' => 'nullable|max:1300',
            'job_q1' => 'nullable|max:191',
            'job_q2' => 'nullable|max:191',
            'job_q3' => 'nullable|max:191',
      ]);

      $disk = Storage::disk('s3');

      if(session()->has('count') == 1) {
        $employer_id = auth('employer')->user()->id;
        $company = Company::where('employer_id', $employer_id)->first();
        $company_id = $company->id;

        $image_path_list = [];
        $edit_image_path_list = [];
        $movie_path_list = [];
        $edit_movie_path_list = [];


        if($request->input('pub_start')) {
          if($request->input('pub_start') == 'start_specified') {
            $pub_start = $request->input('start_specified_date');
          } else {
            $pub_start = $request->input('pub_start');
          }
        }

        if($request->input('pub_end')) {
          if($request->input('pub_end') == 'end_specified') {
            $pub_end = $request->input('end_specified_date');
          } else {
            $pub_end = $request->input('pub_end');
          }
        }

        if(JobItem::where('id',$id)->exists()) {
          // edit

          $job = JobItem::findOrFail($id);

          // ディレクトリを作成
          if (!file_exists(public_path() . \Config::get('fpath.real_img') . $id)) {
            mkdir(public_path() . \Config::get('fpath.real_img') . $id, 0777);
          }
          if (!file_exists(public_path() . \Config::get('fpath.real_mov') . $id)) {
            mkdir(public_path() . \Config::get('fpath.real_mov') . $id, 0777);
          }

          // 一時保存から本番の格納場所へ移動
          //image upload
          if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image'))) {

            $edit_image_path_list = session()->get('data.file.edit_image');

            foreach($edit_image_path_list as $index => $image_path) {
              //main
              if($index == 'main')  {
                if($image_path != '') {
                  if($job->job_img != null && $image_path != $job->job_img && File::exists(public_path() . $job->job_img)) {
                    // local
                    File::delete(public_path() . $job->job_img);
                    // s3
                    if($disk->exists($job->job_img)) {
                      $disk->delete($job->job_img);
                    }
                  
                  }

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $id . "/";

                  rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);

                  $edit_image_path_list['main'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($edit_image_path_list['main'], $contents, 'public');

                } elseif($image_path == '' && $job->job_img != null) {
                  // local
                  if(File::exists(public_path() . $job->job_img)) {
                    File::delete(public_path() . $job->job_img);
                  }
                  // s3
                  if($disk->exists($job->job_img)) {
                    $disk->delete($job->job_img);
                  }

                } else {
                  $edit_image_path_list['main'] = '';
                }

              } elseif ($index == 'sub1')  {
                if($image_path != '') {
                  if($job->job_img2 != null && $image_path != $job->job_img2 && File::exists(public_path() . $job->job_img2)) {

                    File::delete(public_path() . $job->job_img2);

                    if($disk->exists($job->job_img2)) {
                      $disk->delete($job->job_img2);
                    }

                  }

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $id . "/";

                  rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                  
                  $edit_image_path_list['sub1'] = $common_path . "real." . $file_name;
                  
                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($edit_image_path_list['sub1'], $contents, 'public');

                } elseif($image_path == '' && $job->job_img2 != null) {

                  if(File::exists(public_path() . $job->job_img2)) {
                    File::delete(public_path() . $job->job_img2);
                  }
                  // s3
                  if($disk->exists($job->job_img2)) {
                    $disk->delete($job->job_img2);
                  }

                } else {
                  $edit_image_path_list['sub1'] = '';
                }

              } elseif($index == 'sub2')  {
                if($image_path != '') {
                  if($job->job_img3 != null && $image_path != $job->job_img3 && File::exists(public_path() . $job->job_img3)) {

                    File::delete(public_path() . $job->job_img3);

                    if($disk->exists($job->job_img3)) {
                      $disk->delete($job->job_img3);
                    }

                  }

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $id . "/";

                  rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                  
                  $edit_image_path_list['sub2'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($edit_image_path_list['sub2'], $contents, 'public');

                } elseif($image_path == '' && $job->job_img3 != null) {

                  if(File::exists(public_path() . $job->job_img3)) {
                    File::delete(public_path() . $job->job_img3);
                  }
                  // s3
                  if($disk->exists($job->job_img3)) {
                    $disk->delete($job->job_img3);
                  }

                } else {
                  $edit_image_path_list['sub2'] = '';
                }

              }

            }

            if(!isset($edit_image_path_list['main']) && $job->job_img != null) {
              $edit_image_path_list['main'] = $job->job_img;
            } elseif(!isset($edit_image_path_list['main']) && $job->job_img == null) {
              $edit_image_path_list['main'] = null;
            } elseif($edit_image_path_list['main'] == '') {
              $edit_image_path_list['main'] = null;
            }

            if(!isset($edit_image_path_list['sub1']) && $job->job_img2 != null) {
              $edit_image_path_list['sub1'] = $job->job_img2;
            } elseif(!isset($edit_image_path_list['sub1']) && $job->job_img2 == null) {
              $edit_image_path_list['sub1'] = null;
            } elseif($edit_image_path_list['sub1'] == '') {
              $edit_image_path_list['sub1'] = null;
            }

            if(!isset($edit_image_path_list['sub2']) && $job->job_img3 != null) {
              $edit_image_path_list['sub2'] = $job->job_img3;
            } elseif(!isset($edit_image_path_list['sub2']) && $job->job_img3 == null) {
              $edit_image_path_list['sub2'] = null;
            } elseif($edit_image_path_list['sub2'] == '') {
              $edit_image_path_list['sub2'] = null;
            }

          } else {
            if($job->job_img != null) {
              $edit_image_path_list['main'] = $job->job_img;
            } else {
              $edit_image_path_list['main'] = null;
            }

            if($job->job_img2 != null) {
              $edit_image_path_list['sub1'] = $job->job_img2;
            } else {
              $edit_image_path_list['sub1'] = null;
            }

            if($job->job_img3 != null) {
              $edit_image_path_list['sub2'] = $job->job_img3;
            } else {
              $edit_image_path_list['sub2'] = null;
            }

          }

          //movie upload
          if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie'))) {

            $edit_movie_path_list = session()->get('data.file.edit_movie');

            foreach($edit_movie_path_list as $index => $movie_path) {
              //main
              if($index == 'main')  {
                if($movie_path != '') {
                  if($job->job_mov != null && $movie_path != $job->job_mov && File::exists(public_path() . $job->job_mov)) {

                    File::delete(public_path() . $job->job_mov);

                    // s3
                    if($disk->exists($job->job_mov)) {
                      $disk->delete($job->job_mov);
                    }

                  }

                  $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_mov') . $id . "/";

                  rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                  
                  $edit_movie_path_list['main'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($edit_movie_path_list['main'], $contents, 'public');

                } elseif($movie_path == '' && $job->job_mov != null) {

                  if(File::exists(public_path() . $job->job_mov)) {
                    File::delete(public_path() . $job->job_mov);
                  }
                  // s3
                  if($disk->exists($job->job_mov)) {
                    $disk->delete($job->job_mov);
                  }

                } else {
                  $edit_movie_path_list['main'] = '';
                }

              } elseif ($index == 'sub1')  {
                if($movie_path != '') {
                  if($job->job_mov2 != null && $movie_path != $job->job_mov2 && File::exists(public_path() . $job->job_mov2)) {

                    File::delete(public_path() . $job->job_mov2);

                    // s3
                    if($disk->exists($job->job_mov2)) {
                      $disk->delete($job->job_mov2);
                    }

                  }

                  $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_mov') . $id . "/";

                  rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                  
                  $edit_movie_path_list['sub1'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($edit_movie_path_list['sub1'], $contents, 'public');

                } elseif($movie_path == '' && $job->job_mov2 != null) {

                  if(File::exists(public_path() . $job->job_mov2)) {
                    File::delete(public_path() . $job->job_mov2);
                  }
                  // s3
                  if($disk->exists($job->job_mov2)) {
                    $disk->delete($job->job_mov2);
                  }

                } else {
                  $edit_movie_path_list['sub1'] = '';
                }

              } elseif($index == 'sub2')  {
                if($movie_path != '') {
                  if($job->job_mov3 != null && $movie_path != $job->job_mov3 && File::exists(public_path() . $job->job_mov3)) {

                    File::delete(public_path() . $job->job_mov3);
                    // s3
                    if($disk->exists($job->job_mov3)) {
                      $disk->delete($job->job_mov3);
                    }

                  }

                  $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_mov') . $id . "/";

                  rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                  
                  $edit_movie_path_list['sub2'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($edit_movie_path_list['sub2'], $contents, 'public');

                } elseif($movie_path == '' && $job->job_mov3 != null) {

                  if(File::exists(public_path() . $job->job_mov3)) {
                    File::delete(public_path() . $job->job_mov3);
                  }
                  // s3
                  if($disk->exists($job->job_mov3)) {
                    $disk->delete($job->job_mov3);
                  }

                } else {
                  $edit_movie_path_list['sub2'] = '';
                }

              }

            }

            if(!isset($edit_movie_path_list['main']) && $job->job_mov != null) {
              $edit_movie_path_list['main'] = $job->job_mov;
            } elseif(!isset($edit_movie_path_list['main']) && $job->job_mov == null) {
              $edit_movie_path_list['main'] = null;
            } elseif($edit_movie_path_list['main'] == '') {
              $edit_movie_path_list['main'] = null;
            }

            if(!isset($edit_movie_path_list['sub1']) && $job->job_mov2 != null) {
              $edit_movie_path_list['sub1'] = $job->job_mov2;
            } elseif(!isset($edit_movie_path_list['sub1']) && $job->job_mov2 == null) {
              $edit_movie_path_list['sub1'] = null;
            } elseif($edit_movie_path_list['sub1'] == '') {
              $edit_movie_path_list['sub1'] = null;
            }

            if(!isset($edit_movie_path_list['sub2']) && $job->job_mov3 != null) {
              $edit_movie_path_list['sub2'] = $job->job_mov3;
            } elseif(!isset($edit_movie_path_list['sub2']) && $job->job_mov3 == null) {
              $edit_movie_path_list['sub2'] = null;
            } elseif($edit_movie_path_list['sub2'] == '') {
              $edit_movie_path_list['sub2'] = null;
            }

          } else {
            if($job->job_mov != null) {
              $edit_movie_path_list['main'] = $job->job_mov;
            } else {
              $edit_movie_path_list['main'] = null;
            }

            if($job->job_mov2 != null) {
              $edit_movie_path_list['sub1'] = $job->job_mov2;
            } else {
              $edit_movie_path_list['sub1'] = null;
            }

            if($job->job_mov3 != null) {
              $edit_movie_path_list['sub2'] = $job->job_mov3;
            } else {
              $edit_movie_path_list['sub2'] = null;
            }

          }




          if(session()->has('data.form.edit_category')){
            $edit_cat_list = session()->get('data.form.edit_category');

            if(!isset($edit_cat_list['status'])) {
              $edit_cat_list['status'] = $job->status_cat_id;
            }
            if(!isset($edit_cat_list['type'])) {
              $edit_cat_list['type'] = $job->type_cat_id;
            }
            if(!isset($edit_cat_list['area'])) {
              $edit_cat_list['area'] = $job->area_cat_id;
            }
            if(!isset($edit_cat_list['hourly_salary'])) {
              $edit_cat_list['hourly_salary'] = $job->hourly_salary_cat_id;
            }
            if(!isset($edit_cat_list['date'])) {
              $edit_cat_list['date'] = $job->date_cat_id;
            }
          } else {
            $edit_cat_list = [
              'status' => $job->status_cat_id,
              'type' => $job->type_cat_id,
              'area' => $job->area_cat_id,
              'hourly_salary' => $job->hourly_salary_cat_id,
              'date' => $job->date_cat_id,
            ];
          }

          $job->update([
            'status' => 0,
            'job_title' => $request->input('job_title'),
            'job_intro' => $request->input('job_intro'),
            'job_office' => $request->input('job_office'),
            'job_office_address' => $request->input('job_office_address'),
            'job_img' => $edit_image_path_list['main'],
            'job_img2' => $edit_image_path_list['sub1'],
            'job_img3' => $edit_image_path_list['sub2'],
            'job_mov' => $edit_movie_path_list['main'],
            'job_mov2' => $edit_movie_path_list['sub1'],
            'job_mov3' => $edit_movie_path_list['sub2'],
            'job_type' => $request->input('job_type'),
            'job_hourly_salary' => $request->input('job_hourly_salary'),
            'job_desc' => $request->input('job_desc'),
            'job_time' => $request->input('job_time'),
            'salary_increase' => $request->input('salary_increase'),
            'job_target' => $request->input('job_target'),
            'job_treatment' => $request->input('job_treatment'),
            'pub_start' => $pub_start,
            'pub_end' => $pub_end,
            'remarks' => $request->input('remarks'),
            'status_cat_id' => $edit_cat_list['status'],
            'type_cat_id' => $edit_cat_list['type'],
            'area_cat_id' => $edit_cat_list['area'],
            'hourly_salary_cat_id' => $edit_cat_list['hourly_salary'],
            'date_cat_id' => $edit_cat_list['date'],
            'job_q1' => $request->input('job_q1'),
            'job_q2' => $request->input('job_q2'),
            'job_q3' => $request->input('job_q3'),
          ]);

        } else {
          //新規作成時

          $data = JobItem::create([
            'employer_id' => $employer_id,
            'company_id' => $company_id,
            'status' => 0,
            'job_title' => $request->input('job_title'),
            'job_intro' => $request->input('job_intro'),
            'job_office' => $request->input('job_office'),
            'job_office_address' => $request->input('job_office_address'),
            'slug' => str_slug($company_id),
            'job_type' => $request->input('job_type'),
            'job_hourly_salary' => $request->input('job_hourly_salary'),
            'job_desc' => $request->input('job_desc'),
            'job_time' => $request->input('job_time'),
            'salary_increase' => $request->input('salary_increase'),
            'job_target' => $request->input('job_target'),
            'job_treatment' => $request->input('job_treatment'),
            'pub_start' => $pub_start,
            'pub_end' => $pub_end,
            'remarks' => $request->input('remarks'),
            'job_q1' => $request->input('job_q1'),
            'job_q2' => $request->input('job_q2'),
            'job_q3' => $request->input('job_q3'),
            'status_cat_id' => session()->get('data.form.category.status_cat_id'),
            'type_cat_id' => session()->get('data.form.category.type_cat_id'),
            'area_cat_id' => session()->get('data.form.category.area_cat_id'),
            'hourly_salary_cat_id' => session()->get('data.form.category.hourly_salary_cat_id'),
            'date_cat_id' => session()->get('data.form.category.date_cat_id'),
          ]);

          if(JobItem::where('id',$data->id)->exists()) {
            $lastInsertedId = $data->id;
            $job = JobItem::findOrFail($lastInsertedId);

            // ディレクトリを作成
            if (!file_exists(public_path() . \Config::get('fpath.real_img') . $lastInsertedId)) {
              mkdir(public_path() . \Config::get('fpath.real_img') . $lastInsertedId, 0777);
            }
            if (!file_exists(public_path() . \Config::get('fpath.real_mov') . $lastInsertedId)) {
              mkdir(public_path() . \Config::get('fpath.real_mov') . $lastInsertedId, 0777);
            }

            // 一時保存から本番の格納場所へ移動
            // image upload
            if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))) {

              $image_path_list = session()->get('data.file.image');

              foreach($image_path_list as $index => $image_path) {
                if($index == 'main')  {

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $lastInsertedId . "/";

                  rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                  
                  $image_path_list['main'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($image_path_list['main'], $contents, 'public');


                } elseif ($index == 'sub1') {

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $lastInsertedId . "/";

                  rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                  
                  $image_path_list['sub1'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($image_path_list['sub1'], $contents, 'public');


                } elseif ($index == 'sub2') {

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $lastInsertedId . "/";

                  rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                  
                  $image_path_list['sub2'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($image_path_list['sub2'], $contents, 'public');


                } else {

                }
              }

              if(!isset($image_path_list['main'])) {
                $image_path_list['main'] = null;
              }
              if(!isset($image_path_list['sub1'])) {
                $image_path_list['sub1'] = null;
              }
              if(!isset($image_path_list['sub2'])) {
                $image_path_list['sub2'] = null;
              }

            } else {
              $image_path_list['main'] = null;
              $image_path_list['sub1'] = null;
              $image_path_list['sub2'] = null;
            }


            // movie upload
            if(session()->has('data.file.movie') && is_array(session()->get('data.file.movie'))) {

              $movie_path_list = session()->get('data.file.movie');

              foreach($movie_path_list as $index => $movie_path) {
                if($index == 'main')  {

                  $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_mov') . $lastInsertedId . "/";

                  rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                  
                  $movie_path_list['main'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($movie_path_list['main'], $contents, 'public');

                } elseif ($index == 'sub1') {

                  $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_mov') . $lastInsertedId . "/";

                  rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                  
                  $movie_path_list['sub1'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($movie_path_list['sub1'], $contents, 'public');

                } elseif ($index == 'sub2') {

                  $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_mov') . $lastInsertedId . "/";

                  rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                  
                  $movie_path_list['sub2'] = $common_path . "real." . $file_name;

                  // s3
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($movie_path_list['sub2'], $contents, 'public');

                } else {
                }

              }

              if(!isset($movie_path_list['main'])) {
                $movie_path_list['main'] = null;
              }
              if(!isset($movie_path_list['sub1'])) {
                $movie_path_list['sub1'] = null;
              }
              if(!isset($movie_path_list['sub2'])) {
                $movie_path_list['sub2'] = null;
              }

            } else {
              $movie_path_list['main'] = null;
              $movie_path_list['sub1'] = null;
              $movie_path_list['sub2'] = null;
            }



            $job->update([
              'job_img' => $image_path_list['main'],
              'job_img2' => $image_path_list['sub1'],
              'job_img3' => $image_path_list['sub2'],
              'job_mov' => $movie_path_list['main'],
              'job_mov2' => $movie_path_list['sub1'],
              'job_mov3' => $movie_path_list['sub2'],
            ]);
          }

        }

        session()->forget('data');
        session()->forget('count');

      } else {
        session()->forget('count');
      }

    }

    public function storeStep2(Request $request, $id='')
    {
      $this->validate($request,[
            'pub_start' => 'required',
            'pub_end' => 'required',
            'job_title' => 'required|max:30',
            'job_intro' => 'required|max:250',
            'job_office' => 'required|max:191',
            'job_office_address' => 'required|max:191',
            'job_type' => 'required|max:191',
            'job_desc' => 'required|max:700',
            'job_hourly_salary' => 'required|max:191',
            'salary_increase' => 'max:191',
            'job_target' => 'required|max:400',
            'job_time' => 'required|max:400',
            'job_treatment' => 'required|max:400',
            'remarks' => 'max:1300',
            'job_q1' => 'max:191',
            'job_q2' => 'max:191',
            'job_q3' => 'max:191',
      ]);


      if($request->session()->has('count') == 1) {

        $request->session()->put('data.form.text', $request->all());
        $request->session()->forget('count');
        $request->session()->put('count', 2);
        return redirect()->to('/jobs/create/confirm');

      } else {
        $request->session()->forget('count');
        return redirect()->to('/jobs/create/confirm');
      }

    }


    public function createConfirm($id='')
    {
      if(session()->has('count') == 2) {
        if(JobItem::where('id',$id)->exists()){
          $job = JobItem::findOrFail($id);
        } else {
          $job = '';
        }
        session()->forget('count');
        session()->put('count', 3);

        

        return view('jobs.post.confirm', compact('job'));
      } else {
        return redirect()->to('/jobs/create/step1');
      }

    }

    public function storeComplete(Request $request, $id='')
    {
      if(session()->has('count') == 3 ) {

          $employer_id = auth('employer')->user()->id;
          $company = Company::where('employer_id', $employer_id)->first();
          $company_id = $company->id;


          $image_path_list = [];
          $edit_image_path_list = [];
          $movie_path_list = [];
          $edit_movie_path_list = [];

          $disk = Storage::disk('s3');


          if(session()->has('data.form.text.pub_start')) {
            if(session()->get('data.form.text.pub_start') == 'start_specified') {
              $pub_start = session()->get('data.form.text.start_specified_date');
            } else {
              $pub_start = session()->get('data.form.text.pub_start');
            }
          }

          if(session()->has('data.form.text.pub_end')) {
            if(session()->get('data.form.text.pub_end') == 'end_specified') {
              $pub_end = session()->get('data.form.text.end_specified_date');
            } else {
              $pub_end = session()->get('data.form.pub_end');
            }
          }

          if(JobItem::where('id',$id)->exists()) {
            // edit
            $job = JobItem::findOrFail($id);

            // ディレクトリを作成
            if (!file_exists(public_path() . \Config::get('fpath.real_img') . $id)) {
              mkdir(public_path() . \Config::get('fpath.real_img') . $id, 0777);
            }
            if (!file_exists(public_path() . \Config::get('fpath.real_mov') . $id)) {
              mkdir(public_path() . \Config::get('fpath.real_mov') . $id, 0777);
            }

            // 一時保存から本番の格納場所へ移動
            // image upload
            if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image'))) {

              $edit_image_path_list = session()->get('data.file.edit_image');

              foreach($edit_image_path_list as $index => $image_path) {
                if($index == 'main')  {
                  if($image_path != '') {
                    if($job->job_img != null && $image_path != $job->job_img && File::exists(public_path() . $job->job_img)) {

                      File::delete(public_path() . $job->job_img);
                      // s3
                      if($disk->exists($job->job_img)) {
                        $disk->delete($job->job_img);
                      }

                    }

                    $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_img') . $id . "/";

                    rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);

                    $edit_image_path_list['main'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($edit_image_path_list['main'], $contents, 'public');

                  } elseif($image_path == '' && $job->job_img != null) {

                    if(File::exists(public_path() . $job->job_img)) {
                      File::delete(public_path() . $job->job_img);
                    }
                    // s3
                    if($disk->exists($job->job_img)) {
                      $disk->delete($job->job_img);
                    }

                  } else {
                    $edit_image_path_list['main'] = '';
                  }

                } elseif ($index == 'sub1')  {
                  if($image_path != '') {
                    if($job->job_img2 != null && $image_path != $job->job_img2 && File::exists(public_path() . $job->job_img2)) {

                      File::delete(public_path() . $job->job_img2);
                      // s3
                      if($disk->exists($job->job_img2)) {
                        $disk->delete($job->job_img2);
                      }

                    }

                    $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_img') . $id . "/";
  
                    rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                    
                    $edit_image_path_list['sub1'] = $common_path . "real." . $file_name;
                    
                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($edit_image_path_list['sub1'], $contents, 'public');
  

                  } elseif($image_path == '' && $job->job_img2 != null) {

                    if(File::exists(public_path() . $job->job_img2)) {
                      File::delete(public_path() . $job->job_img2);
                    }
                    // s3
                    if($disk->exists($job->job_img2)) {
                      $disk->delete($job->job_img2);
                    }

                  } else {
                    $edit_image_path_list['sub1'] = '';
                  }

                } elseif($index == 'sub2')  {
                  if($image_path != '') {
                    if($job->job_img3 != null && $image_path != $job->job_img3 && File::exists(public_path() . $job->job_img3)) {

                      File::delete(public_path() . $job->job_img3);
                      // s3
                      if($disk->exists($job->job_img3)) {
                        $disk->delete($job->job_img3);
                      }

                    }

                    $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_img') . $id . "/";

                    rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                    
                    $edit_image_path_list['sub2'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($edit_image_path_list['sub2'], $contents, 'public');

                  } elseif($image_path == '' && $job->job_img3 != null) {

                    if(File::exists(public_path() . $job->job_img3)) {
                      File::delete(public_path() . $job->job_img3);
                    }
                    // s3
                    if($disk->exists($job->job_img3)) {
                      $disk->delete($job->job_img3);
                    }

                  } else {
                    $edit_image_path_list['sub2'] = '';
                  }

                }


              }

              if(!isset($edit_image_path_list['main']) && $job->job_img != null) {
                $edit_image_path_list['main'] = $job->job_img;
              } elseif(!isset($edit_image_path_list['main']) && $job->job_img == null) {
                $edit_image_path_list['main'] = null;
              } elseif($edit_image_path_list['main'] == '') {
                $edit_image_path_list['main'] = null;
              }

              if(!isset($edit_image_path_list['sub1']) && $job->job_img2 != null) {
                $edit_image_path_list['sub1'] = $job->job_img2;
              } elseif(!isset($edit_image_path_list['sub1']) && $job->job_img2 == null) {
                $edit_image_path_list['sub1'] = null;
              } elseif($edit_image_path_list['sub1'] == '') {
                $edit_image_path_list['sub1'] = null;
              }

              if(!isset($edit_image_path_list['sub2']) && $job->job_img3 != null) {
                $edit_image_path_list['sub2'] = $job->job_img3;
              } elseif(!isset($edit_image_path_list['sub2']) && $job->job_img3 == null) {
                $edit_image_path_list['sub2'] = null;
              } elseif($edit_image_path_list['sub2'] == '') {
                $edit_image_path_list['sub2'] = null;
              }

            } else {
              if($job->job_img != null) {
                $edit_image_path_list['main'] = $job->job_img;
              } else {
                $edit_image_path_list['main'] = null;
              }

              if($job->job_img2 != null) {
                $edit_image_path_list['sub1'] = $job->job_img2;
              } else {
                $edit_image_path_list['sub1'] = null;
              }

              if($job->job_img3 != null) {
                $edit_image_path_list['sub2'] = $job->job_img3;
              } else {
                $edit_image_path_list['sub2'] = null;
              }
            }

            // movie upload
            if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie'))) {

              $edit_movie_path_list = session()->get('data.file.edit_movie');

              foreach($edit_movie_path_list as $index => $movie_path) {
                if($index == 'main')  {
                  if($movie_path != '') {
                    if($job->job_mov != null && $movie_path != $job->job_mov && File::exists(public_path() . $job->job_mov)) {

                      File::delete(public_path() . $job->job_mov);
                      // s3
                      if($disk->exists($job->job_mov)) {
                        $disk->delete($job->job_mov);
                      }

                    }

                    $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_mov') . $id . "/";

                    rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                    
                    $edit_movie_path_list['main'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($edit_movie_path_list['main'], $contents, 'public');

                  } elseif($movie_path == '' && $job->job_mov != null) {

                    if(File::exists(public_path() . $job->job_mov)) {
                      File::delete(public_path() . $job->job_mov);
                    }
                    // s3
                    if($disk->exists($job->job_mov)) {
                      $disk->delete($job->job_mov);
                    }

                  } else {
                    $edit_movie_path_list['main'] = '';
                  }

                } elseif ($index == 'sub1')  {
                  if($movie_path != '') {
                    if($job->job_mov2 != null && $movie_path != $job->job_mov2 && File::exists(public_path() . $job->job_mov2)) {

                      File::delete(public_path() . $job->job_mov2);
                      // s3
                      if($disk->exists($job->job_mov2)) {
                        $disk->delete($job->job_mov2);
                      }

                    }

                    $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_mov') . $id . "/";

                    rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                    
                    $edit_movie_path_list['sub1'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($edit_movie_path_list['sub1'], $contents, 'public');

                  } elseif($movie_path == '' && $job->job_mov2 != null) {

                    if(File::exists(public_path() . $job->job_mov2)) {
                      File::delete(public_path() . $job->job_mov2);
                    }
                    // s3
                    if($disk->exists($job->job_mov2)) {
                      $disk->delete($job->job_mov2);
                    }

                  } else {
                    $edit_movie_path_list['sub1'] = '';
                  }

                } elseif($index == 'sub2')  {
                  if($movie_path != '') {
                    if($job->job_mov3 != null && $movie_path != $job->job_mov3 && File::exists(public_path() . $job->job_mov3)) {

                      File::delete(public_path() . $job->job_mov3);
                      // s3
                      if($disk->exists($job->job_mov3)) {
                        $disk->delete($job->job_mov3);
                      }

                    }

                    $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_mov') . $id . "/";

                    rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                    
                    $edit_movie_path_list['sub2'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($edit_movie_path_list['sub2'], $contents, 'public');

                  } elseif($movie_path == '' && $job->job_mov3 != null) {

                    if(File::exists(public_path() . $job->job_mov3)) {
                      File::delete(public_path() . $job->job_mov3);
                    }
                    // s3
                    if($disk->exists($job->job_mov3)) {
                      $disk->delete($job->job_mov3);
                    }

                  } else {
                    $edit_movie_path_list['sub2'] = '';
                  }

                }

              }

              if(!isset($edit_movie_path_list['main']) && $job->job_mov != null) {
                $edit_movie_path_list['main'] = $job->job_mov;
              } elseif(!isset($edit_movie_path_list['main']) && $job->job_mov == null) {
                $edit_movie_path_list['main'] = null;
              } elseif($edit_movie_path_list['main'] == '') {
                $edit_movie_path_list['main'] = null;
              }

              if(!isset($edit_movie_path_list['sub1']) && $job->job_mov2 != null) {
                $edit_movie_path_list['sub1'] = $job->job_mov2;
              } elseif(!isset($edit_movie_path_list['sub1']) && $job->job_mov2 == null) {
                $edit_movie_path_list['sub1'] = null;
              } elseif($edit_movie_path_list['sub1'] == '') {
                $edit_movie_path_list['sub1'] = null;
              }

              if(!isset($edit_movie_path_list['sub2']) && $job->job_mov3 != null) {
                $edit_movie_path_list['sub2'] = $job->job_mov3;
              } elseif(!isset($edit_movie_path_list['sub2']) && $job->job_mov3 == null) {
                $edit_movie_path_list['sub2'] = null;
              } elseif($edit_movie_path_list['sub2'] == '') {
                $edit_movie_path_list['sub2'] = null;
              }

            } else {
              if($job->job_mov != null) {
                $edit_movie_path_list['main'] = $job->job_mov;
              } else {
                $edit_movie_path_list['main'] = null;
              }

              if($job->job_mov2 != null) {
                $edit_movie_path_list['sub1'] = $job->job_mov2;
              } else {
                $edit_movie_path_list['sub1'] = null;
              }

              if($job->job_mov3 != null) {
                $edit_movie_path_list['sub2'] = $job->job_mov3;
              } else {
                $edit_movie_path_list['sub2'] = null;
              }
            }


            if(session()->has('data.form.edit_category')){
              $edit_cat_list = session()->get('data.form.edit_category');

              if(!isset($edit_cat_list['status'])) {
                $edit_cat_list['status'] = $job->status_cat_id;
              }
              if(!isset($edit_cat_list['type'])) {
                $edit_cat_list['type'] = $job->type_cat_id;
              }
              if(!isset($edit_cat_list['area'])) {
                $edit_cat_list['area'] = $job->area_cat_id;
              }
              if(!isset($edit_cat_list['hourly_salary'])) {
                $edit_cat_list['hourly_salary'] = $job->hourly_salary_cat_id;
              }
              if(!isset($edit_cat_list['date'])) {
                $edit_cat_list['date'] = $job->date_cat_id;
              }
            } else {
              $edit_cat_list = [
                'status' => $job->status_cat_id,
                'type' => $job->type_cat_id,
                'area' => $job->area_cat_id,
                'hourly_salary' => $job->hourly_salary_cat_id,
                'date' => $job->date_cat_id,
              ];
            }


            $job->update([
              'status' => 1,
              'job_title' => session()->get('data.form.text.job_title'),
              'job_intro' => session()->get('data.form.text.job_intro'),
              'job_office' => session()->get('data.form.text.job_office'),
              'job_office_address' => session()->get('data.form.text.job_office_address'),
              'job_img' => $edit_image_path_list['main'],
              'job_img2' => $edit_image_path_list['sub1'],
              'job_img3' => $edit_image_path_list['sub2'],
              'job_mov' => $edit_movie_path_list['main'],
              'job_mov2' => $edit_movie_path_list['sub1'],
              'job_mov3' => $edit_movie_path_list['sub2'],
              'job_type' => session()->get('data.form.text.job_type'),
              'job_hourly_salary' => session()->get('data.form.text.job_hourly_salary'),
              'job_desc' => session()->get('data.form.text.job_desc'),
              'job_time' => session()->get('data.form.text.job_time'),
              'salary_increase' => session()->get('data.form.text.salary_increase'),
              'job_target' => session()->get('data.form.text.job_target'),
              'job_treatment' => session()->get('data.form.text.job_treatment'),
              'pub_start' => $pub_start,
              'pub_end' => $pub_end,
              'remarks' => session()->get('data.form.text.remarks'),
              'status_cat_id' => $edit_cat_list['status'],
              'type_cat_id' => $edit_cat_list['type'],
              'area_cat_id' => $edit_cat_list['area'],
              'hourly_salary_cat_id' => $edit_cat_list['hourly_salary'],
              'date_cat_id' => $edit_cat_list['date'],
              'job_q1' => session()->get('data.form.text.job_q1'),
              'job_q2' => session()->get('data.form.text.job_q2'),
              'job_q3' => session()->get('data.form.text.job_q3'),
            ]);



          } else {

            $data = JobItem::create([
              'employer_id' => $employer_id,
              'company_id' => $company_id,
              'status' => 1,
              'job_title' => session()->get('data.form.text.job_title'),
              'job_intro' => session()->get('data.form.text.job_intro'),
              'job_office' => session()->get('data.form.text.job_office'),
              'job_office_address' => session()->get('data.form.text.job_office_address'),
              'slug' => str_slug($company_id),
              'job_type' => session()->get('data.form.text.job_type'),
              'job_hourly_salary' => session()->get('data.form.text.job_hourly_salary'),
              'job_desc' => session()->get('data.form.text.job_desc'),
              'job_time' => session()->get('data.form.text.job_time'),
              'salary_increase' => session()->get('data.form.text.salary_increase'),
              'job_target' => session()->get('data.form.text.job_target'),
              'job_treatment' => session()->get('data.form.text.job_treatment'),
              'pub_start' => $pub_start,
              'pub_end' => $pub_end,
              'remarks' => session()->get('data.form.text.remarks'),
              'job_q1' => session()->get('data.form.text.job_q1'),
              'job_q2' => session()->get('data.form.text.job_q2'),
              'job_q3' => session()->get('data.form.text.job_q3'),
              'status_cat_id' => session()->get('data.form.category.status_cat_id'),
              'type_cat_id' => session()->get('data.form.category.type_cat_id'),
              'area_cat_id' => session()->get('data.form.category.area_cat_id'),
              'hourly_salary_cat_id' => session()->get('data.form.category.hourly_salary_cat_id'),
              'date_cat_id' => session()->get('data.form.category.date_cat_id'),
            ]);

            if(JobItem::where('id',$data->id)->exists()) {

              $lastInsertedId = $data->id;
              $job = JobItem::findOrFail($lastInsertedId);

              // ディレクトリを作成
              if (!file_exists(public_path() . \Config::get('fpath.real_img') . $lastInsertedId)) {
                mkdir(public_path() . \Config::get('fpath.real_img') . $lastInsertedId, 0777);
              }
              if (!file_exists(public_path() . \Config::get('fpath.real_mov') . $lastInsertedId)) {
                mkdir(public_path() . \Config::get('fpath.real_mov') . $lastInsertedId, 0777);
              }

              // 一時保存から本番の格納場所へ移動
              // image upload
              if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))) {

                $image_path_list = session()->get('data.file.image');

                foreach($image_path_list as $index => $image_path) {
                  if($index == 'main')  {

                    $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_img') . $lastInsertedId . "/";
  
                    rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                    
                    $image_path_list['main'] = $common_path . "real." . $file_name;
  
                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($image_path_list['main'], $contents, 'public');

                  } elseif ($index == 'sub1') {

                    $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_img') . $lastInsertedId . "/";

                    rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                    
                    $image_path_list['sub1'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($image_path_list['sub1'], $contents, 'public');


                  } elseif ($index == 'sub2') {

                    $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_img') . $lastInsertedId . "/";

                    rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                    
                    $image_path_list['sub2'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($image_path_list['sub2'], $contents, 'public');

                  } else {

                  }

                }

                if(!isset($image_path_list['main'])) {
                  $image_path_list['main'] = null;
                }
                if(!isset($image_path_list['sub1'])) {
                  $image_path_list['sub1'] = null;
                }
                if(!isset($image_path_list['sub2'])) {
                  $image_path_list['sub2'] = null;
                }

              } else {
                $image_path_list['main'] = null;
                $image_path_list['sub1'] = null;
                $image_path_list['sub2'] = null;
              }


              // movie upload
              if(session()->has('data.file.movie') && is_array(session()->get('data.file.movie'))) {

                $movie_path_list = session()->get('data.file.movie');

                foreach($movie_path_list as $index => $movie_path) {
                  if($index == 'main')  {

                    $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_mov') . $lastInsertedId . "/";

                    rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                    
                    $movie_path_list['main'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($movie_path_list['main'], $contents, 'public');

                  } elseif ($index == 'sub1') {

                    $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_mov') . $lastInsertedId . "/";

                    rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                    
                    $movie_path_list['sub1'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($movie_path_list['sub1'], $contents, 'public');


                  } elseif ($index == 'sub2') {

                    $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_mov') . $lastInsertedId . "/";

                    rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                    
                    $movie_path_list['sub2'] = $common_path . "real." . $file_name;

                    // s3
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($movie_path_list['sub2'], $contents, 'public');

                  } else {

                  }

                }

                if(!isset($movie_path_list['main'])) {
                  $movie_path_list['main'] = null;
                }
                if(!isset($movie_path_list['sub1'])) {
                  $movie_path_list['sub1'] = null;
                }
                if(!isset($movie_path_list['sub2'])) {
                  $movie_path_list['sub2'] = null;
                }

              } else {
                $movie_path_list['main'] = null;
                $movie_path_list['sub1'] = null;
                $movie_path_list['sub2'] = null;
              }



              $job->update([
                'job_img' => $image_path_list['main'],
                'job_img2' => $image_path_list['sub1'],
                'job_img3' => $image_path_list['sub2'],
                'job_mov' => $movie_path_list['main'],
                'job_mov2' => $movie_path_list['sub1'],
                'job_mov3' => $movie_path_list['sub2'],
              ]);
            }
          }


          session()->forget('data');
          session()->forget('count');

          return view('jobs.post.create_complete');

      } else {
        session()->forget('count');
        return redirect()->to('/jobs/create/step1');
      }

    }

    public function jobFormShow($id)
    {

      $job = JobItem::findOrFail($id);
      $employer_id = auth('employer')->user()->id;
      $company = Company::where('employer_id', $employer_id)->first();

      return view('jobs.post.show', compact('job', 'company'));
    }


    public function getMyjobAppDelete($id)
    {
      $job = JobItem::findOrFail($id);
      $job->update([
        'status' => 5,
      ]);

      return redirect()->back()->with('message_success','削除申請をしました');
    }
    public function getMyjobAppDeleteCancel($id)
    {
      $job = JobItem::findOrFail($id);
      if($job->status !== 5 ) {
        return redirect()->back()->with('message_alert','不正なリクエストです');;
      }

      $job->update([
        'status' => 0,
      ]);

      return redirect()->back()->with('message_success','削除申請を取り消しました');
    }

    public function getMyjobAppStop($id)
    {
      $job = JobItem::findOrFail($id);
      $job->update([
        'status' => 4,
      ]);

      return redirect()->back()->with('message_success','公開を停止しました');
    }

    public function getMyjobAppCancel($id)
    {
      $job = JobItem::findOrFail($id);
      if($job->status !== 1 ) {
        return redirect()->back();
      }

      return view('jobs.myjob_app_cancel', compact('job'));
    }

    public function postMyjobAppCancel(Request $request, $id)
    {
      $job = JobItem::findOrFail($id);
      $job->update([
        'status' => $request->input('status'),
      ]);

      return redirect()->route('job.edit', ['id' => $job->id])->with('message_success','申請を取り消しました');
    }


    public function getApplyStep1($id)
    {
      $job = JobItem::findOrFail($id);
      if(Auth::user()) {
        $user = auth()->user();
        $user_id = $user->id;
        $profile = Profile::where('user_id',$user_id)->first();
        $postcode = $profile['postcode'];
        $postcode = str_replace("-", "", $postcode);
        $postcode1 = substr($postcode,0,3);
        $postcode2 = substr($postcode,3);
      }
      session()->forget('jobapp_count');
      session()->put('jobapp_count', 1);

      return view('jobs.apply_step1', compact('user','job', 'postcode1', 'postcode2'));
    }
    public function postApplyStep1(Request $request, $id)
    {

      $this->validate($request,[
            'last_name' => 'required|string|max:191|kana',
            'first_name' => 'required|string|max:191|kana',
            'phone1' => 'required|numeric|digits_between:2,5',
            'phone2' => 'required|numeric|digits_between:1,4',
            'phone3' => 'required|numeric|digits_between:3,4',
            'gender' => 'required',
            'age' => 'required|numeric|between:15,99',
            'zip31' => 'required|numeric|digits:3',
            'zip32' => 'required|numeric|digits:4',
            'pref31' => 'required|string|max:191',
            'addr31' => 'required|string|max:191',
            'occupation' => 'required|not_in',
            'final_education' => 'required|not_in',
            'work_start_date' => 'required',
            'job_msg' => 'max:1000',
            'job_q1' => 'max:1000',
            'job_q2' => 'max:1000',
            'job_q3' => 'max:1000',
      ]);

      if($request->session()->has('jobapp_count') == 1) {

        $request->session()->put('jobapp_data', $request->all());
        $request->session()->forget('jobapp_count');
        $request->session()->put('jobapp_count', 2);
        return redirect()->action('JobController@getApplyStep2', ['id' => $id]);
      }

      $request->session()->forget('jobapp_count');
      $request->session()->forget('jobapp_data');
      return redirect()->to('/');
    }

    public function getApplyStep2($id)
    {

      if(session()->has('jobapp_count') == 2) {
        $job = JobItem::findOrFail($id);
        return view('jobs.apply_step2', compact('job'));
      }

      session()->forget('jobapp_count');
      session()->forget('jobapp_data');

      return redirect()->to('/');


    }

    public function postApplyStep2(Request $request, $id)
    {
      if(session()->has('jobapp_count') == 2) {

        $jobId = JobItem::findOrFail($id);
        $appUser = $jobId->users()->where('user_id', auth()->user()->id)->first();
        $company = $jobId->company;
        $employer = $jobId->employer;


        $postal_code = $request->session()->get('jobapp_data.zip31') . "-" . $request->session()->get('jobapp_data.zip32');

        $jobAppData = $request->session()->get('jobapp_data');
        $jobId->users()->attach(Auth::user()->id,[
          'employer_id' => $employer->id,
          's_status' => 0,
          'e_status' => 0,
          'last_name' => $request->session()->get('jobapp_data.last_name'),
          'first_name' => $request->session()->get('jobapp_data.first_name'),
          'postcode' => $postal_code,
          'prefecture' => $request->session()->get('jobapp_data.pref31'),
          'city' => $request->session()->get('jobapp_data.addr31'),
          'gender' => $request->session()->get('jobapp_data.gender'),
          'age' => $request->session()->get('jobapp_data.age'),
          'phone1' => $request->session()->get('jobapp_data.phone1'),
          'phone2' => $request->session()->get('jobapp_data.phone2'),
          'phone3' => $request->session()->get('jobapp_data.phone3'),
          'occupation' => $request->session()->get('jobapp_data.occupation'),
          'final_education' => $request->session()->get('jobapp_data.final_education'),
          'work_start_date' => $request->session()->get('jobapp_data.work_start_date'),
          'phone3' => $request->session()->get('jobapp_data.phone3'),
          'job_msg' => $request->session()->get('jobapp_data.job_msg'),
          'job_q1' => $request->session()->get('jobapp_data.job_q1'),
          'job_q2' => $request->session()->get('jobapp_data.job_q2'),
          'job_q3' => $request->session()->get('jobapp_data.job_q3'),
        ]);


        Mail::to(auth()->user()->email)->queue(new JobAppliedSeeker($jobId, $jobAppData, $company, $employer));
        Mail::to($employer->email)->queue(new JobAppliedEmployer($appUser, $jobId, $jobAppData, $company, $employer));

        session()->forget('jobapp_count');
        session()->put('jobapp_count', 3);
        return redirect()->action('JobController@completeJobApply', ['id' => $id]);

      }

      $request->session()->forget('jobapp_count');
      $request->session()->forget('jobapp_data');
      return redirect()->to('/');
    }

    public function completeJobApply($id)
    {
      if(session()->has('jobapp_count') == 3) {

        $job = JobItem::findOrFail($id);
        session()->forget('jobapp_count');
        session()->forget('jobapp_data');
        return view('jobs.apply_complete', compact('job'));
      }
      session()->forget('jobapp_count');
      session()->forget('jobapp_data');
      return redirect()->to('/');

    }

    public function getFavoriteJobs()
    {
      $jobs = Auth::user()->favourites;

      return view('jobs.fovourites', compact('jobs'));

    }

    public function allJobs(Request $request)
    {
      $keyword = $request->get('title');
      $status = $request->get('status_cat_id');
      $type = $request->get('type_cat_id');
      $area = $request->get('area_cat_id');
      $hourlySaraly = $request->get('hourly_salary_cat_id');
      $date = $request->get('date_cat_id');

      $typeCatArchive = '';
      $areaCatArchive = '';

      // 検索QUERY
      $query = JobItem::query();

      //結合

        if(!empty($keyword)){
          $query->where('job_title','like','%'.$keyword.'%')
                ->orWhere('job_type', 'like','%'.$keyword.'%')
                ->orWhere('job_hourly_salary', 'like','%'.$keyword.'%')
                ->orWhere('job_target', 'like','%'.$keyword.'%')
                ->orWhere('job_treatment', 'like','%'.$keyword.'%')
                ->orWhere('job_office_address', 'like','%'.$keyword.'%');

        }

        $query->whereHas('status_cat_get', function ($query) use($status){
          if(!empty($status)){
            $query->where('status_categories.id', $status);
          }
        });
        $query->whereHas('type_cat_get', function ($query) use($type){
          if(!empty($type)){
            $query->where('type_categories.id', $type);
          }
        });
        $query->whereHas('area_cat_get', function ($query) use($area){
          if(!empty($area)){
            $query->where('area_categories.id', $area);
          }
        });
        $query->whereHas('hourly_salary_cat_get', function ($query) use($hourlySaraly){
          if(!empty($hourlySaraly)){
            $query->where('hourly_salary_categories.id', $hourlySaraly);
          }
        });
        $query->whereHas('date_cat_get', function ($query) use($date){
          if(!empty($date)){
            $query->where('date_categories.id', $date);
          }
        });


      // ページネーション

      $today = date("Y-m-d");

      $jobs = $query->where('status', 2)
                ->where(function($query) use ($today){
                  $query->orWhere('pub_end', '>', $today)
                        ->orWhere('pub_end','無期限で掲載');
                })->where(function($query) use ($today){
                  $query->orWhere('pub_start', '<', $today)
                        ->orWhere('pub_start','最短で掲載');
                })->latest()->paginate(5);

      //件数表示の例外処理
      if( Input::get('page') > $jobs->LastPage()) {
        abort(404);
      }

      $hash = array(
          'keyword' => $keyword,
          'status' => $status,
          'type' => $type,
          'area' => $area,
          'hourlySaraly' => $hourlySaraly,
          'jobs' => $jobs,
          'date' => $date,
          );

       return view('jobs.alljobs')->with($hash);

    }

    public function realSearchJob($statusVal, $typeVal, $areaVal, $hourlySalaryVal, $dateVal, $textVal = '')
    {
      $today = date("Y-m-d");

      $searchJobs = JobItem::where('status', 2)
        ->where(function($query) use ($today){
          $query->orWhere('pub_end', '>', $today)
                ->orWhere('pub_end','無期限で掲載');
        })->where(function($query) use ($today){
          $query->orWhere('pub_start', '<', $today)
                ->orWhere('pub_start','最短で掲載');
        });

        if($textVal != ''){
          $searchJobs->where('job_title','like','%'.$textVal.'%')
                ->orWhere('job_type', 'like','%'.$textVal.'%')
                ->orWhere('job_hourly_salary', 'like','%'.$textVal.'%')
                ->orWhere('job_target', 'like','%'.$textVal.'%')
                ->orWhere('job_treatment', 'like','%'.$textVal.'%')
                ->orWhere('job_office_address', 'like','%'.$textVal.'%');
        }
        $jobCount = $searchJobs
                  ->when($statusVal != 0, function($query) use($statusVal){
                    return $query->where('status_cat_id', $statusVal);
                  })
                  ->when($typeVal != 0, function($query) use($typeVal){
                    return $query->where('type_cat_id', $typeVal);
                  })
                  ->when($areaVal != 0, function($query) use($areaVal){
                    return $query->where('area_cat_id', $areaVal);
                  })
                  ->when($hourlySalaryVal != 0, function($query) use($hourlySalaryVal){
                    return $query->where('hourly_salary_cat_id', $hourlySalaryVal);
                  })
                  ->when($dateVal != 0, function($query) use($dateVal){
                    return $query->where('date_cat_id', $dateVal);
                  })

                  ->count();

        return response()->json($jobCount);
    }
}
