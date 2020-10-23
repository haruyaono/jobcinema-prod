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

  public function index()
  {
    $topNewJobs = $this->JobItem->activeJobitem()->latest()->limit(3)->get();
    $jobCount = $this->jobItemRepo->listJobitemCount();
    $categoryList = $this->categoryRepo->listCategories('id', 'asc');

    return view('jobs.index', compact('topNewJobs', 'jobCount', 'categoryList'));
  }

  public function show(Request $request, JobItem $jobitem)
  {
    session()->forget('jobapp_data');

    $id = $jobitem->id;
    $recommendJobList = [];
    $jobItemRepo = new JobItemRepository($jobitem);

    if (Auth::check()) {
      $user = $this->userRepo->findUserById(auth()->user()->id);

      Redis::command('LREM', ['Viewer:Item:' . $id, 0, $user->id]);
      Redis::command('RPUSH', ['Viewer:Item:' . $id, $user->id]);
      Redis::command('LTRIM', ['Viewer:Item:' . $id, 0, 999]);

      $existsApplied = $this->userRepo->existsAppliedJobItem($user, $id);

      $this->JobItem->calcRecommend();
      $recommendJobIds = $this->JobItem->getRecommendJobList($id, $request);

      if ($recommendJobIds != []) {
        $recommendJobList = $this->jobItemRepo->find($recommendJobIds);
      }
    }

    $this->jobItemRepo->createRecentJobItemIdList($request, $id);

    if ($jobitem->status == 2) {
      return view('jobs.show', compact('jobitem', 'existsApplied', 'recommendJobList'));
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

  public function search(Request $request)
  {
    $searchParam = $request->all();
    $categoryList = $this->categoryRepo->listCategories('id', 'asc');

    if (array_key_exists('ks', $searchParam) && $searchParam['ks'] != '') {
      switch ($searchParam['ks']['f']) {
        case '1':
          $searchParam['ks']['slug'] = 'salary';
          $searchParam['ks']['parent'] = 'salary_h';
          break;
        case '2':
          $searchParam['ks'][''] = 'salary';
          $searchParam['ks']['parent'] = 'salary_d';
          break;
        case '3':
          $searchParam['ks']['slug'] = 'salary';
          $searchParam['ks']['parent'] = 'salary_';
          break;
        case '4':
          $searchParam['ks']['slug'] = 'date';
          $searchParam['ks']['order'] = 'asc';
          break;
        case '5':
          $searchParam['ks']['slug'] = 'oiwaikin';
          break;
        default:
          break;
      }
    }

    $query = $this->jobItemRepo->baseSearchJobItems($searchParam);

    $totalJobItem = $query->count();
    $jobitems = $query->paginate(20);

    if (Input::get('page') > $jobitems->LastPage()) {
      abort(404);
    }

    $hash = array(
      'jobitems' => $jobitems,
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
