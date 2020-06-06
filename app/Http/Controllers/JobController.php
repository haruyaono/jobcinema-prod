<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use App\Job\Users\User;
use App\Job\Users\Repositories\UserRepository;
use App\Job\JobItems\JobItem;
use App\Job\Profiles\Profile;
use App\Models\PostalCode;
use App\Job\Companies\Company;
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
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;

class JobController extends Controller
{

    /**
     * @var CategoryRepositoryInterface
     * @var JobItemRepositoryInterface
    *  @var UserRepositoryInterface
     */
    private $categoryRepo;
    private $jobItemRepo;
    private $userRepo;

    private $job_form_session = 'count';
    private $JobItem;
    
     /**
     * JobController constructor.
     * @param JobItem $JobItem
     * @param CategoryRepositoryInterface $categoryRepository
     * @param JobItemRepositoryInterface $jobItemRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
      JobItem $JobItem, 
      CategoryRepositoryInterface $categoryRepository,
      JobItemRepositoryInterface $jobItemRepository,
      UserRepositoryInterface $userRepository
    ) {

      $this->JobItem = $JobItem;
      $this->categoryRepo = $categoryRepository;
      $this->jobItemRepo = $jobItemRepository;
      $this->userRepo = $userRepository;
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

      $exists = Storage::disk('s3')->exists('resume/'.$applicantUser->profile->resume);
      if($exists) {
          $resumePath =  Storage::disk('s3')->url('resume/'.$applicantUser->profile->resume);
          if(config('app.env') == 'production') {
              $resumePath = str_replace('s3.ap-northeast-1.amazonaws.com/', '', $resumePath);
          } 
          
      } else {
          $resumePath = '';
      }

      return view('jobs.applicants_detail', compact('job', 'applicantUser', 'applicantUserInfo', 'resumePath'));
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

        if(config('app.env') == 'production') {
          $jobImageBaseUrl = config('app.s3_url');
        } else {
          $jobImageBaseUrl = '';
        }
       

      } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){

        return redirect()->route('my.job')->with('message_alert', '該当する求人票が見つかりません。');

      }

      return view('jobs.post.edit', compact('job', 'jobImageBaseUrl'));
      
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

      var_dump(session()->all());

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
     

      if(session()->has('count') == 1 || session()->has('count') == 3) {

        session()->forget('data.file.edit_image');
        session()->forget('data.file.edit_movie');

        $jobImageBaseUrl = $this->jobItemRepo->getJobImageBaseUrl();

        return view('jobs.post.create_step2', compact('jobItem', 'jobImageBaseUrl'));

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
              return back()->with('message','メイン画像を登録してください');
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
              switch($index) {
                case $index == 'main':
                  $jobImageDbPath = $job->job_img;
                  break;
                case $index == 'sub1':
                  $jobImageDbPath = $job->job_img2;
                  break;
                case $index == 'sub2':
                  $jobImageDbPath = $job->job_img3;
                  break;
              }

              if($image_path != '') {
                if($jobImageDbPath != null && $image_path != $jobImageDbPath && File::exists(public_path() . $jobImageDbPath)) {
                  // local
                  File::delete(public_path() . $jobImageDbPath);
                  // s3
                  if($disk->exists($jobImageDbPath)) {
                    $disk->delete($jobImageDbPath);
                  }
                }

                $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                $common_path = \Config::get('fpath.real_img') . $id . "/";

                // ローカルの一時保存フォルダから、ローカルの本番フォルダに移動
                rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);

                // ローカルの本番フォルダにある画像パスを変数に格納
                $edit_image_path_list[$index] = $common_path . "real." . $file_name;

                // s3の一時保存フォルダにある画像を削除
                if($disk->exists($image_path)) {
                  $disk->delete($image_path);
                }

                // s3の本番フォルダに保存
                $contents = File::get(public_path() . $common_path . "real." . $file_name);
                $disk->put($edit_image_path_list[$index], $contents, 'public');

              } elseif($image_path == '' && $jobImageDbPath != null) {
                // local
                if(File::exists(public_path() . $jobImageDbPath)) {
                  File::delete(public_path() . $jobImageDbPath);
                }
                // s3
                if($disk->exists($jobImageDbPath)) {
                  $disk->delete($jobImageDbPath);
                }

              } else {
                $edit_image_path_list[$index] = '';
              }

              if(!isset($edit_image_path_list[$index]) && $jobImageDbPath != null) {
                $edit_image_path_list[$index] = $jobImageDbPath;
              } elseif(!isset($edit_image_path_list[$index]) && $jobImageDbPath == null) {
                $edit_image_path_list[$index] = null;
              } elseif($edit_image_path_list[$index] == '') {
                $edit_image_path_list[$index] = null;
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
              switch($index) {
                case $index == 'main':
                  $jobMovieDbPath = $job->job_mov;
                  break;
                case $index == 'sub1':
                  $jobMovieDbPath = $job->job_mov2;
                  break;
                case $index == 'sub2':
                  $jobMovieDbPath = $job->job_mov3;
                  break;
              }

              if($movie_path != '') {
                
                if($jobMovieDbPath != null && $movie_path != $jobMovieDbPath && File::exists(public_path() . $jobMovieDbPath)) {

                  File::delete(public_path() . $jobMovieDbPath);

                  // s3
                  if($disk->exists($jobMovieDbPath)) {
                    $disk->delete($jobMovieDbPath);
                  }

                }

                $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                $common_path = \Config::get('fpath.real_mov') . $id . "/";

                // ローカルの一時保存フォルダから、ローカルの本番フォルダに移動
                rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                
                 // ローカルの本番フォルダにある動画パスを変数に格納
                $edit_movie_path_list[$index] = $common_path . "real." . $file_name;

                // s3の一時保存フォルダにある画像を削除
                if($disk->exists($movie_path)) {
                  $disk->delete($movie_path);
                }

                // s3の本番フォルダに保存
                $contents = File::get(public_path() . $common_path . "real." . $file_name);
                $disk->put($edit_movie_path_list[$index], $contents, 'public');

              } elseif($movie_path == '' && $jobMovieDbPath != null) {

                // ローカルファイル削除
                if(File::exists(public_path() . $jobMovieDbPath)) {
                  File::delete(public_path() . $jobMovieDbPath);
                }
                // s3にあるファイルを削除
                if($disk->exists($jobMovieDbPath)) {
                  $disk->delete($jobMovieDbPath);
                }

              } else {
                $edit_movie_path_list[$index] = '';
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

                $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                $common_path = \Config::get('fpath.real_img') . $lastInsertedId . "/";

                // ローカルの一時保存フォルダから、ローカルの本番フォルダに移動
                rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                
                // ローカルの本番フォルダにある画像パスを変数に格納
                $image_path_list[$index] = $common_path . "real." . $file_name;

                // s3の一時保存フォルダにある画像を削除
                if($disk->exists($image_path)) {
                  $disk->delete($image_path);
                }

                // s3の本番フォルダに保存
                $contents = File::get(public_path() . $common_path . "real." . $file_name);
                $disk->put($image_path_list[$index], $contents, 'public');
                
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

                $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                $common_path = \Config::get('fpath.real_mov') . $lastInsertedId . "/";

                // ローカルの一時保存フォルダから、ローカルの本番フォルダに移動
                rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                
                 // ローカルの本番フォルダにある動画パスを変数に格納
                $movie_path_list[$index] = $common_path . "real." . $file_name;

                // s3の一時保存フォルダにある動画を削除
                if($disk->exists($movie_path)) {
                  $disk->delete($movie_path);
                }

                // s3の本番フォルダに保存
                $contents = File::get(public_path() . $common_path . "real." . $file_name);
                $disk->put($movie_path_list[$index], $contents, 'public');

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
        $jobImageBaseUrl = $this->jobItemRepo->getJobImageBaseUrl();

        return view('jobs.post.confirm', compact('job', 'jobImageBaseUrl'));
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
              $pub_end = session()->get('data.form.text.pub_end');
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

                switch($index) {
                  case $index == 'main':
                    $jobImageDbPath = $job->job_img;
                    break;
                  case $index == 'sub1':
                    $jobImageDbPath = $job->job_img2;
                    break;
                  case $index == 'sub2':
                    $jobImageDbPath = $job->job_img3;
                    break;
                }

              
                if($image_path != '') {
                  if($jobImageDbPath != null && $image_path != $jobImageDbPath && File::exists(public_path() . $jobImageDbPath)) {

                    File::delete(public_path() . $jobImageDbPath);
                    // s3
                    if($disk->exists($jobImageDbPath)) {
                      $disk->delete($jobImageDbPath);
                    }

                  }

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $id . "/";

                  rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);

                  $edit_image_path_list[$index] = $common_path . "real." . $file_name;

                  // s3の一時保存フォルダにある画像を削除
                  if($disk->exists($image_path)) {
                    $disk->delete($image_path);
                  }

                  // s3の本番フォルダに保存
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($edit_image_path_list[$index], $contents, 'public');

                } elseif($image_path == '' && $jobImageDbPath != null) {

                  if(File::exists(public_path() . $jobImageDbPath)) {
                    File::delete(public_path() . $jobImageDbPath);
                  }
                  // s3
                  if($disk->exists($jobImageDbPath)) {
                    $disk->delete($jobImageDbPath);
                  }

                } else {
                  $edit_image_path_list[$index] = '';
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

                switch($index) {
                  case $index == 'main':
                    $jobMovieDbPath = $job->job_mov;
                    break;
                  case $index == 'sub1':
                    $jobMovieDbPath = $job->job_mov2;
                    break;
                  case $index == 'sub2':
                    $jobMovieDbPath = $job->job_mov3;
                    break;
                }

                  if($movie_path != '') {
                    if($jobMovieDbPath != null && $movie_path != $jobMovieDbPath && File::exists(public_path() . $jobMovieDbPath)) {

                      File::delete(public_path() . $jobMovieDbPath);
                      // s3
                      if($disk->exists($jobMovieDbPath)) {
                        $disk->delete($jobMovieDbPath);
                      }

                    }

                    $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                    $common_path = \Config::get('fpath.real_mov') . $id . "/";

                    rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                    
                    $edit_movie_path_list[$index] = $common_path . "real." . $file_name;

                    // s3の一時保存フォルダにある動画を削除
                    if($disk->exists($movie_path)) {
                      $disk->delete($movie_path);
                    }

                    // s3の本番フォルダに保存
                    $contents = File::get(public_path() . $common_path . "real." . $file_name);
                    $disk->put($edit_movie_path_list[$index], $contents, 'public');

                  } elseif($movie_path == '' && $jobMovieDbPath != null) {

                    if(File::exists(public_path() . $jobMovieDbPath)) {
                      File::delete(public_path() . $jobMovieDbPath);
                    }
                    // s3
                    if($disk->exists($jobMovieDbPath)) {
                      $disk->delete($jobMovieDbPath);
                    }

                  } else {
                    $edit_movie_path_list[$index ] = '';
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

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $lastInsertedId . "/";

                  rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);
                  
                  $image_path_list[$index] = $common_path . "real." . $file_name;

                  // s3の一時保存フォルダにある画像を削除
                  if($disk->exists($image_path)) {
                    $disk->delete($image_path);
                  }

                  // s3の本番フォルダに保存
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($image_path_list[$index], $contents, 'public');

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
                
                  $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_mov') . $lastInsertedId . "/";

                  rename(public_path() . $movie_path, public_path() . $common_path . "real." . $file_name);
                  
                  $movie_path_list[$index] = $common_path . "real." . $file_name;

                  // s3の一時保存フォルダにある動画を削除
                  if($disk->exists($movie_path)) {
                    $disk->delete($movie_path);
                  }

                  // s3の本番フォルダに保存
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($movie_path_list[$index], $contents, 'public');

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

}
