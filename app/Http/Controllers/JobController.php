<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use App\Job\Users\Repositories\UserRepository;
use App\Job\Profiles\Repositories\ProfileRepository;
use App\Job\JobItems\JobItem;
use App\Job\JobItems\Repositories\JobItemRepository;
use App\Job\Companies\Company;
use App\Job\Employers\Repositories\EmployerRepository;
use App\Job\JobItems\Requests\JobCreateStep1Request;
use App\Job\JobItems\Requests\JobCreateStep2Request;
use App\Job\JobItems\Requests\JobCreateTmpSaveRequest;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Job\Applies\Repositories\Interfaces\ApplyRepositoryInterface;
use App\Job\Employers\Repositories\Interfaces\EmployerRepositoryInterface;

class JobController extends Controller
{

    /**
     * @var CategoryRepositoryInterface
     * @var JobItemRepositoryInterface
     * @var UserRepositoryInterface
     * @var ApplyRepositoryInterface
     * @var EmployerRepositoryInterface
     */
    private $categoryRepo;
    private $jobItemRepo;
    private $userRepo;
    private $applyRepo;
    private $employerRepo;

    private $job_form_session = 'count';
    private $JobItem;
    
     /**
     * JobController constructor.
     * @param JobItem $JobItem
     * @param CategoryRepositoryInterface $categoryRepository
     * @param JobItemRepositoryInterface $jobItemRepository
     * @param UserRepositoryInterface $userRepository
     * @param ApplyRepositoryInterface $applyRepository
     * @param EmployerRepositoryInterface $employerRepository
     */
    public function __construct(
      JobItem $JobItem, 
      CategoryRepositoryInterface $categoryRepository,
      JobItemRepositoryInterface $jobItemRepository,
      UserRepositoryInterface $userRepository,
      ApplyRepositoryInterface $applyRepository,
      EmployerRepositoryInterface $employerRepository
    ) {

      $this->JobItem = $JobItem;
      $this->categoryRepo = $categoryRepository;
      $this->jobItemRepo = $jobItemRepository;
      $this->userRepo = $userRepository;
      $this->applyRepo = $applyRepository;
      $this->employerRepo = $employerRepository;
    }

    public function applicant()
    {
      $employer = auth('employer')->user();
      $jobItems = $employer->jobs;
      $applyJobList = [];
      
      foreach($jobItems as $jobitem) {
        if($jobitem->applies->count() === 0) {
          continue;
        }

        $applyJobList[$jobitem->id] = [];

        foreach($jobitem->applies as $key => $apply) {
          if($apply->user === null) {

            if($jobitem->applies->count() === 1) {
              unset($applyJobList[$jobitem->id]);
            }
            continue;
          }
        
          array_push($applyJobList[$jobitem->id], $apply);
        }
      }

      return view('jobs.applicants', compact('applyJobList'));
    }
    
    public function applicantDetail($JobItemId, $applyId)
    {
      $applyInfo = [];
      $employer = auth('employer')->user();

      $applyInfo['jobitem'] = $employer->jobs->find($JobItemId);
      if($applyInfo['jobitem'] === null) {
        return view('errors.employer.custom')->with('error_name', 'NotJobItem');
      }

      $applyInfo['jobAppliedInfo'] = $applyInfo['jobitem']->applies()
                ->wherePivot('apply_id', $applyId)
                ->wherePivot('job_item_id', $applyInfo['jobitem']->id)
                ->first();
      
      if($applyInfo['jobAppliedInfo'] === null) {
        return view('errors.employer.custom')->with('error_name', 'NotAppliedJobItem');
      }

      $applyInfo['apply'] = $this->applyRepo->findApplyById($applyInfo['jobAppliedInfo']->id);
      $applyInfo['applicant'] = $this->userRepo->findUserById($applyInfo['apply']->user_id);

      $profileRepo = new ProfileRepository($applyInfo['applicant']->profile);
      $applyInfo['profile'] = $profileRepo->getResume();

      return view('jobs.applicants_detail', compact('applyInfo'));
    }

    public function empAdoptJob($JobItemId, $applyId)
    {
      $employer = auth('employer')->user();
      $jobitem = $employer->jobs->find($JobItemId);

      $jobItemRepo = new JobItemRepository($jobitem);

      $data = [
        'e_status' => 1,
      ];
      $jobItemRepo->updateAppliedJobItem($applyId, $data);

      session()->flash('flash_message_success', '採用通知しました！');
      return redirect()->route('applicants.view');
    }

    public function empUnAdoptJob($JobItemId, $applyId)
    {
      $employer = auth('employer')->user();
      $jobitem = $employer->jobs->find($JobItemId);

      $jobItemRepo = new JobItemRepository($jobitem);

      $data = [
        'e_status' => 2,
      ];
      $jobItemRepo->updateAppliedJobItem($applyId, $data);

      session()->flash('flash_message_success', '不採用通知しました！');
      return redirect()->route('applicants.view');
    }

    public function empAdoptCancelJob($JobItemId, $applyId)
    {
        $employer = auth('employer')->user();
        $jobitem = $employer->jobs->find($JobItemId);

        $jobItemRepo = new JobItemRepository($jobitem);

        $data = [
          'e_status' => 0,
        ];
        $jobItemRepo->updateAppliedJobItem($applyId, $data);

        session()->flash('flash_message_success', '採用を取り消しました！');
        return redirect()->route('applicants.view');
    }

    public function index()
    {

      $employer = auth('employer')->user();
      $list = $this->employerRepo->findJobItems($employer)->sortBy('created_at')->all();

      $jobs = $this->jobItemRepo->paginateArrayResults($list, 10);
      //件数表示の例外処理
      if( Input::get('page') > $jobs->LastPage()) {
        abort(404);
      }
      
      return view('jobs.myjob', compact('jobs'));
    }

    public function edit(JobItem $jobItem)
    {

      $this->authorize('view', $jobItem);
      session()->put('count', 1);

      if(session()->get('data.jobId') !== $jobItem->id ) {
        session()->forget(['data']);
      }

      // 新規作成時のファイル用セッションが残っていたら削除
      if(session()->has('data.file.image')) {
        session()->forget('data.file.image');
      }
      if(session()->has('data.file.movie')) {
        session()->forget('data.file.movie');
      }
      $job = $jobItem;

      if(config('app.env') == 'production') {
        $jobImageBaseUrl = config('app.s3_url');
      } else {
        $jobImageBaseUrl = '';
      }

      return view('jobs.post.edit', compact('job', 'jobImageBaseUrl'));
    }

    public function catEdit(JobItem $jobItem, $category)
    {
      $this->authorize('view', $jobItem);

      return view('jobs.post.cat_edit', compact('jobItem', 'category'));
    }

    public function catUpdate(Request $request, JobItem $jobItem)
    {
      $this->authorize('view', $jobItem);

      if(session()->has('data.form.edit_category')){
        $edit_cat_list = session()->get('data.form.edit_category');
      }

      $categoryFlag = $request->input('cat_flag');
      $edit_cat_list[$categoryFlag] = $request->input($categoryFlag . '_cat_id');

      $request->session()->put('data.form.edit_category', $edit_cat_list);
      $request->session()->put('data.jobId', $jobItem->id);

      return redirect()->route('job.edit', [$jobItem->id]);
    }

    public function createTop()
    {
      session()->forget('data');
      session()->forget('count');

      return view('jobs.post.top_create');
    }

    public function createStep1()
    {
      $categoryList = $this->categoryRepo->allCategories();

      if (preg_match("/iPhone|iPod|Android.*Mobile|Windows.*Phone/", $_SERVER['HTTP_USER_AGENT'])) {
        return view('jobs.post.create_step1_sp', compact('categoryList'));
      } else {
        return view('jobs.post.create_step1', compact('categoryList'));
      }
    }

    public function createStep2()
    {
      if(session()->get('count') === 1 || session()->get('count') === 3) {
       
        $jobImageBaseUrl = $this->jobItemRepo->getJobImageBaseUrl();

        return view('jobs.post.create_step2', compact('jobItem', 'jobImageBaseUrl'));
      } else {

        session()->forget('count');
        return redirect()->route('job.create.step1');
      }
    }

    public function storeStep1 (JobCreateStep1Request $request)
    {
      $request->session()->put('data.form.category', $request->all());
      $request->session()->put('count', 1);

      return redirect()->route('job.create.step2');
    }

    public function storeDraft(JobCreateTmpSaveRequest $request, $id=''){

      $disk = Storage::disk('s3');

      if(session()->get('count') === 1) {
        $employer = auth('employer')->user();
        $company = $employer->company;

        $image_path_list = [];
        $edit_image_path_list = [];
        $movie_path_list = [];
        $edit_movie_path_list = [];

        if($pubStartReq = $request->input('pub_start')) {
          if($pubStartReq === 'start_specified') {
            $pub_start = $request->input('start_specified_date');
          } else {
            $pub_start = $pubStartReq;
          }
        }

        if($pubEndReq = $request->input('pub_end')) {
          if($pubEndReq === 'end_specified') {
            $pub_end = $request->input('end_specified_date');
          } else {
            $pub_end = $pubEndReq;
          }
        }

        $fileSessionKeys = config('const.FILE_SLUG');
       
        if($id) {
          // edit
          $job = $this->jobItemRepo->findAllJobItemById($id);
          $savedFilePath = $this->jobItemRepo->savedDbFilePath($job);

          $reqData = $request->except('_token', 'start_specified_date', 'end_specified_date');

          // ディレクトリを作成
          if (!file_exists(public_path() . \Config::get('fpath.real_img') . $job->id)) {
            mkdir(public_path() . \Config::get('fpath.real_img') . $job->id, 0777);
          }
          if (!file_exists(public_path() . \Config::get('fpath.real_mov') . $job->id)) {
            mkdir(public_path() . \Config::get('fpath.real_mov') . $job->id, 0777);
          }

          // 一時保存から本番の格納場所へ移動
          //image upload
          if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image'))) {

            $edit_image_path_list = session()->get('data.file.edit_image');

            foreach($edit_image_path_list as $index => $image_path) {
              //main
              $jobImageDbPath = $savedFilePath['image'][$index];

              if($image_path !== '') {
                if($jobImageDbPath !== null && $image_path !== $jobImageDbPath && File::exists(public_path() . $jobImageDbPath)) {
                  // local
                  File::delete(public_path() . $jobImageDbPath);
                  // s3
                  if($disk->exists($jobImageDbPath)) {
                    $disk->delete($jobImageDbPath);
                  }
                }

                $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                $common_path = \Config::get('fpath.real_img') . $job->id . "/";

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

              } elseif($image_path === '' && $jobImageDbPath !== null) {
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

            }

            foreach($fileSessionKeys as $fileSessionKey) {
              if(!isset($edit_image_path_list[$fileSessionKey]) && $savedFilePath['image'][$fileSessionKey] !== null) {
                $edit_image_path_list[$fileSessionKey] = $savedFilePath['image'][$fileSessionKey];
              } elseif(!isset($edit_image_path_list[$fileSessionKey]) && $savedFilePath['image'][$fileSessionKey] === null) {
                $edit_image_path_list[$fileSessionKey] = null;
              } elseif($edit_image_path_list[$fileSessionKey] === '') {
                $edit_image_path_list[$fileSessionKey] = null;
              }
            }

          } else {
            foreach($fileSessionKeys as $fileSessionKey) {
              if($savedFilePath['image'][$fileSessionKey] !== null) {
                $edit_image_path_list[$fileSessionKey] = $savedFilePath['image'][$fileSessionKey];
              } else {
                $edit_image_path_list[$fileSessionKey] = null;
              }
            }
          }

          //movie upload
          if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie'))) {

            $edit_movie_path_list = session()->get('data.file.edit_movie');

            foreach($edit_movie_path_list as $index => $movie_path) {
              $jobMovieDbPath = $savedFilePath['movie'][$index];

              if($movie_path !== '') {
                if($jobMovieDbPath !== null && $movie_path !== $jobMovieDbPath && File::exists(public_path() . $jobMovieDbPath)) {

                  File::delete(public_path() . $jobMovieDbPath);
                  // s3
                  if($disk->exists($jobMovieDbPath)) {
                    $disk->delete($jobMovieDbPath);
                  }
                }

                $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
                $common_path = \Config::get('fpath.real_mov') . $job->id . "/";

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

              } elseif($movie_path === '' && $jobMovieDbPath !== null) {

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

            foreach($fileSessionKeys as $fileSessionKey) {
              if(!isset($edit_movie_path_list[$fileSessionKey]) && $savedFilePath['movie'][$fileSessionKey] !== null) {
                $edit_movie_path_list[$fileSessionKey] = $savedFilePath['movie'][$fileSessionKey];
              } elseif(!isset($edit_movie_path_list[$fileSessionKey]) && $savedFilePath['movie'][$fileSessionKey] === null) {
                $edit_movie_path_list[$fileSessionKey] = null;
              } elseif($edit_movie_path_list[$fileSessionKey] === '') {
                $edit_movie_path_list[$fileSessionKey] = null;
              }
            }
      
          } else {
            foreach($fileSessionKeys as $fileSessionKey) {
              if($savedFilePath['movie'][$fileSessionKey] !== null) {
                $edit_movie_path_list[$fileSessionKey] = $savedFilePath['movie'][$fileSessionKey];
              } else {
                $edit_movie_path_list[$fileSessionKey] = null;
              }
            }
          }

          $categorySlugList = config('const.CATEGORY_SLUG');

          foreach($categorySlugList as $categorySlug) {
            $columnStoring = $categorySlug.'_cat_id';

            if(session()->has('data.form.edit_category')){
              $edit_cat_list = session()->get('data.form.edit_category');

              if(!isset($edit_cat_list[$categorySlug])) {
                $reqData[$categorySlug.'_cat_id'] = $job->$columnStoring;
              } else {
                $reqData[$categorySlug.'_cat_id'] = $edit_cat_list[$categorySlug];
              }

            } else {
              $reqData[$categorySlug.'_cat_id'] = $job->$columnStoring;
            }
          }
        
          $reqData['status'] = 0;
          $reqData['pub_start'] = $pub_start;
          $reqData['pub_end'] = $pub_end;
          $reqData['job_img'] = $edit_image_path_list['main'];
          $reqData['job_img2'] = $edit_image_path_list['sub1'];
          $reqData['job_img3'] = $edit_image_path_list['sub2'];
          $reqData['job_mov'] = $edit_movie_path_list['main'];
          $reqData['job_mov2'] = $edit_movie_path_list['sub1'];
          $reqData['job_mov3'] = $edit_movie_path_list['sub2'];

          $jobItemRepo = new JobItemRepository($job);
          $jobItemRepo->updatejobItem($reqData);

        } else {

          $reqData = $request->except('_token', 'start_specified_date', 'end_specified_date');
          $reqData['employer_id'] = $employer->id;
          $reqData['company_id'] = $company->id;
          $reqData['status'] = 0;
          $reqData['pub_start'] = $pub_start;
          $reqData['pub_end'] = $pub_end;
          $reqData['status_cat_id'] = $request->session()->get('data.form.category.status_cat_id');
          $reqData['type_cat_id'] = $request->session()->get('data.form.category.type_cat_id');
          $reqData['area_cat_id'] = $request->session()->get('data.form.category.area_cat_id');
          $reqData['hourly_salary_cat_id'] = $request->session()->get('data.form.category.hourly_salary_cat_id');
          $reqData['date_cat_id'] = $request->session()->get('data.form.category.date_cat_id');

          $created = $this->jobItemRepo->createJobItem($reqData);

          // ディレクトリを作成
          if (!file_exists(public_path() . \Config::get('fpath.real_img') . $created->id)) {
            mkdir(public_path() . \Config::get('fpath.real_img') . $created->id, 0777);
          }
          if (!file_exists(public_path() . \Config::get('fpath.real_mov') . $created->id)) {
            mkdir(public_path() . \Config::get('fpath.real_mov') . $created->id, 0777);
          }

          // 一時保存から本番の格納場所へ移動
          // image upload
          if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))) {

            $image_path_list = session()->get('data.file.image');

            foreach($image_path_list as $index => $image_path) {

              $file_name = pathinfo($image_path, PATHINFO_BASENAME);
              $common_path = \Config::get('fpath.real_img') . $created->id . "/";

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

            foreach($fileSessionKeys as $fileSessionKey) {
              if(!isset($image_path_list[$fileSessionKey])) {
                $image_path_list[$fileSessionKey] = null;
              }
            }

          } else {
            foreach($fileSessionKeys as $fileSessionKey) {
                $image_path_list[$fileSessionKey] = null;
            }
          }

          // movie upload
          if(session()->has('data.file.movie') && is_array(session()->get('data.file.movie'))) {

            $movie_path_list = session()->get('data.file.movie');

            foreach($movie_path_list as $index => $movie_path) {

              $file_name = pathinfo($movie_path, PATHINFO_BASENAME);
              $common_path = \Config::get('fpath.real_mov') . $created->id . "/";

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

            foreach($fileSessionKeys as $fileSessionKey) {
              if(!isset($movie_path_list[$fileSessionKey])) {
                $movie_path_list[$fileSessionKey] = null;
              }
            }

          } else {
            foreach($fileSessionKeys as $fileSessionKey) {
              $movie_path_list[$fileSessionKey] = null;
            }
          }

          $jobItemRepo = new JobItemRepository($created);
          $jobItemRepo->updatejobItem([
            'job_img' => $image_path_list['main'],
            'job_img2' => $image_path_list['sub1'],
            'job_img3' => $image_path_list['sub2'],
            'job_mov' => $movie_path_list['main'],
            'job_mov2' => $movie_path_list['sub1'],
            'job_mov3' => $movie_path_list['sub2'],
          ]);
        }

        session()->forget('data');
        session()->forget('count');

        return view('jobs.post.create_tmp_complete');
      } else {

        session()->forget('count');
        return redirect()->route('job.create.top');
      }
    }

    public function storeStep2(JobCreateStep2Request $request, $id='')
    {

      if($request->session()->get('count') === 1 || $request->session()->get('count') === 3) {

        $request->session()->put('data.form.text', $request->all());

        $request->session()->forget('count');
        $request->session()->put('count', 2);

        if($id) {
          $job = $this->jobItemRepo->findAllJobItemById($id);
          $request->session()->put('data.jobId', $job->id);

          if($request->session()->has('data.file.edit_image.main') === false ){
            if($job->job_img === null) {
              return redirect()->back()->with('message_danger','メイン画像を登録してください');
            }
          } elseif ($request->session()->has('data.file.edit_image.main') === true && $request->session()->get('data.file.edit_image.main') === "") {
            return redirect()->back()->with('message_danger','メイン画像を登録してください');
          }

          return redirect()->route('job.create.confirm', [$job->id]);

        } else {
          if($request->session()->has('data.file.image.main') === false){
            return redirect()->back()->with('message','メイン画像を登録してください');
          }
          return redirect()->route('job.create.confirm');
        }

      } else {

        $request->session()->forget('count');
        return redirect()->back();
      }
    }

    public function createConfirm($id='')
    {
      if(session()->get('count') === 2) {
        if($id){
          $job = $this->jobItemRepo->findAllJobItemById($id);
        } else {
          $job = '';
        }

        session()->forget('count');
        session()->put('count', 3);
        $jobImageBaseUrl = $this->jobItemRepo->getJobImageBaseUrl();

        return view('jobs.post.confirm', compact('job', 'jobImageBaseUrl'));
      } else {
        return redirect()->route('job.create.step1');
      }
    }

    public function storeComplete(Request $request, $id='')
    {

;      if(session()->get('count') === 3 ) {

          $employer = auth('employer')->user();
          $company =  $employer->company;

          $image_path_list = [];
          $edit_image_path_list = [];
          $movie_path_list = [];
          $edit_movie_path_list = [];

          $disk = Storage::disk('s3');

          if(session()->has('data.form.text.pub_start')) {
            $pubStartReq = session()->get('data.form.text.pub_start');
            if($pubStartReq === 'start_specified') {
              $pub_start = session()->get('data.form.text.start_specified_date');
            } else {
              $pub_start = $pubStartReq;
            }
          }

          if(session()->has('data.form.text.pub_end')) {
            $pubEndReq = session()->get('data.form.text.pub_end');
            if($pubEndReq === 'end_specified') {
              $pub_end = session()->get('data.form.text.end_specified_date');
            } else {
              $pub_end = $pubEndReq;
            }
          }

          $reqData = $request->session()->get('data.form.text');
          $fileSessionKeys = config('const.FILE_SLUG');

          if($id) {
            // edit
            $job = $this->jobItemRepo->findAllJobItemById($id);
            $savedFilePath = $this->jobItemRepo->savedDbFilePath($job);
  
            foreach( $reqData as $sKey => $sValue ){
              if( $sKey === '_token' || $sKey === 'start_specified_date' || $sKey === 'end_specified_date') {
                unset($reqData[$sKey]);
              } 
            }

            // ディレクトリを作成
            if (!file_exists(public_path() . \Config::get('fpath.real_img') . $job->id)) {
              mkdir(public_path() . \Config::get('fpath.real_img') . $job->id, 0777);
            }
            if (!file_exists(public_path() . \Config::get('fpath.real_mov') . $job->id)) {
              mkdir(public_path() . \Config::get('fpath.real_mov') . $job->id, 0777);
            }    

            // 一時保存から本番の格納場所へ移動
            // image upload
            if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image'))) {

              $edit_image_path_list = session()->get('data.file.edit_image');

              foreach($edit_image_path_list as $index => $image_path) {
                $jobImageDbPath = $savedFilePath['image'][$index];
              
                if($image_path !== '') {
                  if($jobImageDbPath != null && $image_path != $jobImageDbPath && File::exists(public_path() . $jobImageDbPath)) {

                    File::delete(public_path() . $jobImageDbPath);
                    // s3
                    if($disk->exists($jobImageDbPath)) {
                      $disk->delete($jobImageDbPath);
                    }

                  }

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $job->id . "/";

                  rename(public_path() . $image_path, public_path() . $common_path . "real." . $file_name);

                  $edit_image_path_list[$index] = $common_path . "real." . $file_name;

                  // s3の一時保存フォルダにある画像を削除
                  if($disk->exists($image_path)) {
                    $disk->delete($image_path);
                  }

                  // s3の本番フォルダに保存
                  $contents = File::get(public_path() . $common_path . "real." . $file_name);
                  $disk->put($edit_image_path_list[$index], $contents, 'public');

                } elseif($image_path === '' && $jobImageDbPath !== null) {

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

              foreach($fileSessionKeys as $fileSessionKey) {
                if(!isset($edit_image_path_list[$fileSessionKey]) && $savedFilePath['image'][$fileSessionKey] !== null) {
                  $edit_image_path_list[$fileSessionKey] = $savedFilePath['image'][$fileSessionKey];
                } elseif(!isset($edit_image_path_list[$fileSessionKey]) && $savedFilePath['image'][$fileSessionKey] === null) {
                  $edit_image_path_list[$fileSessionKey] = null;
                } elseif($edit_image_path_list[$fileSessionKey] === '') {
                  $edit_image_path_list[$fileSessionKey] = null;
                }
              }
            } else {
              foreach($fileSessionKeys as $fileSessionKey) {
                if($savedFilePath['image'][$fileSessionKey] !== null) {
                  $edit_image_path_list[$fileSessionKey] = $savedFilePath['image'][$fileSessionKey];
                } else {
                  $edit_image_path_list[$fileSessionKey] = null;
                }
              }
            }

            // movie upload
            if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie'))) {

              $edit_movie_path_list = session()->get('data.file.edit_movie');

              foreach($edit_movie_path_list as $index => $movie_path) {
                $jobMovieDbPath = $savedFilePath['movie'][$index];

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

              foreach($fileSessionKeys as $fileSessionKey) {
                if(!isset($edit_movie_path_list[$fileSessionKey]) && $savedFilePath['movie'][$fileSessionKey] !== null) {
                  $edit_movie_path_list[$fileSessionKey] = $savedFilePath['movie'][$fileSessionKey];
                } elseif(!isset($edit_movie_path_list[$fileSessionKey]) && $savedFilePath['movie'][$fileSessionKey] === null) {
                  $edit_movie_path_list[$fileSessionKey] = null;
                } elseif($edit_movie_path_list[$fileSessionKey] === '') {
                  $edit_movie_path_list[$fileSessionKey] = null;
                }
              }

            } else {
              foreach($fileSessionKeys as $fileSessionKey) {
                if($savedFilePath['movie'][$fileSessionKey] !== null) {
                  $edit_movie_path_list[$fileSessionKey] = $savedFilePath['movie'][$fileSessionKey];
                } else {
                  $edit_movie_path_list[$fileSessionKey] = null;
                }
              }
            }

            $categorySlugList = config('const.CATEGORY_SLUG');

            foreach($categorySlugList as $categorySlug) {
              $columnStoring = $categorySlug.'_cat_id';

              if(session()->has('data.form.edit_category')){
                $edit_cat_list = session()->get('data.form.edit_category');

                if(!isset($edit_cat_list[$categorySlug])) {
                  $reqData[$categorySlug.'_cat_id'] = $job->$columnStoring;
                } else {
                  $reqData[$categorySlug.'_cat_id'] = $edit_cat_list[$categorySlug];
                }

              } else {
                $reqData[$categorySlug.'_cat_id'] = $job->$columnStoring;
              }
            }

            $reqData['status'] = 1;
            $reqData['pub_start'] = $pub_start;
            $reqData['pub_end'] = $pub_end;
            $reqData['job_img'] = $edit_image_path_list['main'];
            $reqData['job_img2'] = $edit_image_path_list['sub1'];
            $reqData['job_img3'] = $edit_image_path_list['sub2'];
            $reqData['job_mov'] = $edit_movie_path_list['main'];
            $reqData['job_mov2'] = $edit_movie_path_list['sub1'];
            $reqData['job_mov3'] = $edit_movie_path_list['sub2'];

            $jobItemRepo = new JobItemRepository($job);
            $jobItemRepo->updatejobItem($reqData);
      
          } else {

            foreach( $reqData as $sKey => $sValue ){
              if( $sKey === '_token' || $sKey === 'start_specified_date' || $sKey === 'end_specified_date') {
                unset($reqData[$sKey]);
              } 
            }
            $reqData['employer_id'] = $employer->id;
            $reqData['company_id'] = $company->id;
            $reqData['status'] = 1;
            $reqData['pub_start'] = $pub_start;
            $reqData['pub_end'] = $pub_end;
            $reqData['status_cat_id'] = $request->session()->get('data.form.category.status_cat_id');
            $reqData['type_cat_id'] = $request->session()->get('data.form.category.type_cat_id');
            $reqData['area_cat_id'] = $request->session()->get('data.form.category.area_cat_id');
            $reqData['hourly_salary_cat_id'] = $request->session()->get('data.form.category.hourly_salary_cat_id');
            $reqData['date_cat_id'] = $request->session()->get('data.form.category.date_cat_id');

            $created = $this->jobItemRepo->createJobItem($reqData);

            if($created) {

              $createdId = $created->id;

              // ディレクトリを作成
              if (!file_exists(public_path() . \Config::get('fpath.real_img') . $createdId)) {
                mkdir(public_path() . \Config::get('fpath.real_img') . $createdId, 0777);
              }
              if (!file_exists(public_path() . \Config::get('fpath.real_mov') . $createdId)) {
                mkdir(public_path() . \Config::get('fpath.real_mov') . $createdId, 0777);
              }

              // 一時保存から本番の格納場所へ移動
              // image upload
              if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))) {

                $image_path_list = session()->get('data.file.image');

                foreach($image_path_list as $index => $image_path) {

                  $file_name = pathinfo($image_path, PATHINFO_BASENAME);
                  $common_path = \Config::get('fpath.real_img') . $createdId . "/";

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
                  $common_path = \Config::get('fpath.real_mov') . $createdId . "/";

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


              $jobItemRepo = new JobItemRepository($created);

              $jobItemRepo->updatejobItem([
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
        return redirect()->route('job.create.step1');
      }
    }

    public function jobFormShow(JobItem $jobitem)
    {
      $this->authorize('view', $jobitem);

      $job = $this->jobItemRepo->findAllJobItemById($jobitem->id);
      $employer = auth('employer')->user();
      $company = $employer->company;

      return view('jobs.post.show', compact('job', 'company'));
    }

    public function getMyjobAppDelete(JobItem $jobitem)
    {
      $this->authorize('view', $jobitem);
      $job = $this->jobItemRepo->findAllJobItemById($jobitem->id);

      $jobItemRepo = new JobItemRepository($job);
      $jobItemRepo->updateJobItem([
        'status' => 5,
      ]);

      return redirect()->back()->with('message_success','削除申請を受け付けました');
    }

    public function getMyjobAppDeleteCancel(JobItem $jobitem)
    {
      $this->authorize('view', $jobitem);
      $job = $this->jobItemRepo->findAllJobItemById($jobitem->id);
      if($job->status !== 5 ) {
        return redirect()->back()->with('message_alert','削除申請されておりません');
      }

      $jobItemRepo = new JobItemRepository($job);
      $jobItemRepo->updateJobItem([
        'status' => 0,
      ]);

      return redirect()->back()->with('message_success','削除申請を取り消しました');
    }

    public function getMyjobAppStop(JobItem $jobitem)
    {
      $this->authorize('view', $jobitem);
      $job = $this->jobItemRepo->findAllJobItemById($jobitem->id);

      $jobItemRepo = new JobItemRepository($job);
      $jobItemRepo->updateJobItem([
        'status' => 4,
      ]);

      return redirect()->back()->with('message_success','公開を停止しました');
    }

    public function getMyjobAppCancel(JobItem $jobitem)
    {
      $this->authorize('view', $jobitem);
      $job = $this->jobItemRepo->findAllJobItemById($jobitem->id);
      if($job->status !== 1 ) {
        return redirect()->back()->with('message_alert','求人は公開されておりません');
      }

      return view('jobs.myjob_app_cancel', compact('job'));
    }

    public function postMyjobAppCancel(Request $request, JobItem $jobitem)
    {
      $this->authorize('view', $jobitem);
      $job = $this->jobItemRepo->findAllJobItemById($jobitem->id);

      $jobItemRepo = new JobItemRepository($job);
      $jobItemRepo->updateJobItem([
        'status' => $request->input('status'),
      ]);
  
      return redirect()->route('job.edit', ['jobitem' => $job])->with('message_success','申請を取り消しました');
    }

}
