<?php


namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use App\Job\Users\User;
use App\Job\Users\Repositories\UserRepository;
use App\Job\JobItems\JobItem;
use App\Job\JobItems\Repositories\JobItemRepository;
use App\Job\Companies\Company;
use Illuminate\Support\Facades\Auth;
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Controllers\Controller;

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

    public function index(Request $request)
    {
      $topNewJobs = $this->JobItem->activeJobitem()->latest()->limit(3)->get();
      $jobCount = $this->jobItemRepo->listJobitemCount();
      $categoryList = $this->categoryRepo->listCategories('id', 'asc');

      return view('jobs.index', compact('topNewJobs', 'jobCount', 'categoryList'));
    }

    public function show(Request $request, $id)
    {

      session()->forget('jobapp_data');
 
      $recommendJobList = [];
      $category = [];
      $job = $this->jobItemRepo->findJobItemById($id);
      $jobItemRepo = new JobItemRepository($job);

      if(Auth::check()) {
        $user = $this->userRepo->findUserById(auth()->user()->id);

        Redis::command('LREM', ['Viewer:Item:'.$id, 0, $user->id]);
        Redis::command('RPUSH', ['Viewer:Item:'.$id, $user->id]);
        Redis::command('LTRIM', ['Viewer:Item:'.$id, 0, 999]);

        $existsApplied = $this->userRepo->existsAppliedJobItem($user, $id);
  
        $this->JobItem->calcRecommend();
        $recommendJobIds = $this->JobItem->getRecommendJobList($id, $request);

        if($recommendJobIds != []) {
          $recommendJobList = $this->jobItemRepo->find($recommendJobIds);
        }
      }

      // 最近見た求人リストの配列を操作
      $this->jobItemRepo->createRecentJobItemIdList($request, $id);

      if($job->status == 2) {
        $title = $job->company->cname;

        if(config('app.env') == 'production') {
          $jobImageBaseUrl = config('app.s3_url');
        } else {
          $jobImageBaseUrl = '';
        }

        return view('jobs.show', compact('job', 'title', 'jobImageBaseUrl', 'existsApplied', 'recommendJobList'));
      } else {
        if($jobitem_id_list && in_array($id, $jobitem_id_list) ) {
          $index = array_search( $id, $jobitem_id_list, true );
          session()->forget("recent_jobs.$index");
        } 
      }

      return redirect()->to('/');
    }

     // 最近見た求人リスト
     public function getJobHistory() 
     {
      $jobs = $this->jobItemRepo->listRecentJobItemId(1);
   
      return view('jobs.history', compact('jobs'));
     }

    // 最近見た求人のリストを返す
    public function postJobHistory(Request $request) 
    {
      $jobs = $this->jobItemRepo->listRecentJobItemId(0);
      
      return response()->json($jobs);
    }

    public function allJobs(Request $request)
    {
      $searchParam = $request->all();
      $categoryList = $this->categoryRepo->listCategories('id', 'asc');

      if(array_key_exists('ks', $searchParam) && $searchParam['ks'] != '') {

        switch ($searchParam['ks']['f']) {
          case '1':
            $searchParam['ks']['c_id'] = $this->categoryRepo->listCategoriesByslug('salary', 'salary_h')->first()->parent->id;
            break;
          case '2':
            $searchParam['ks']['c_id'] = $this->categoryRepo->listCategoriesByslug('salary', 'salary_d')->first()->parent->id;
            break;
          case '3':
            $searchParam['ks']['c_id'] = $this->categoryRepo->listCategoriesByslug('salary', 'salary_m')->first()->parent->id;
            break;
          case '4':
            $searchParam['ks']['c_id'] = $this->categoryRepo->listCategoriesByslug('date')->first()
            ->parent->id;
            $searchParam['ks']['order'] = 'asc';
            break;
          case '5':
            $searchParam['ks']['column'] = 'oiwaikin';
            break;
          default:
            break;
        }
      }

      $query = $this->jobItemRepo->baseSearchJobItems($searchParam);


      
      $totalJobItem = $query->count();
      $jobs = $query->latest()->paginate(20);

      //件数表示の例外処理
      if( Input::get('page') > $jobs->LastPage()) {
        abort(404);
      }

      $hash = array(
          'jobs' => $jobs,
          'jobCount' => $totalJobItem,
          'categoryList' => $categoryList,
          'searchParam' => $searchParam
      );

       return view('jobs.alljobs')->with($hash);

    }

    public function realSearchJob(Request $request)
    {

      $searchParam = $request->all(); 
      $query = $this->jobItemRepo->baseSearchJobItems($searchParam);

      $jobCount = $query->count();

      return response()->json($jobCount);
    }
}
