<?php


namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\JobItem;
use Illuminate\Support\Facades\Auth;
use App\Services\JobItemService;
use App\Services\JobItemSearchService;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
  private $JobItem;
  private $JobItemService;
  private $JobItemSearchService;
  private $CategoryRepository;

  public function __construct(
    JobItem $JobItem,
    JobItemService $jobItemService,
    JobItemSearchService $jobItemSearchService,
    CategoryRepository $categoryRepository
  ) {
    $this->JobItem = $JobItem;
    $this->JobItemService = $jobItemService;
    $this->JobItemSearchService = $jobItemSearchService;
    $this->CategoryRepository = $categoryRepository;
  }

  public function index()
  {
    Log::debug('aa');
    $jobitems = $this->JobItem->activeJobitem()->get();
    $topNewJobs = $jobitems->sortBy('created_at')->take(3);
    $categories = $this->CategoryRepository->getCategories();

    return view('front.index', compact('jobitems', 'topNewJobs', 'categories'));
  }

  public function show(Request $request, JobItem $jobitem)
  {
    $recommendJobList = [];
    $exists = false;

    if (Auth::guard('seeker')->check()) {
      $user = auth('seeker')->user();

      Redis::command('LREM', ['Viewer:Item:' . $jobitem->id, 0, $user->id]);
      Redis::command('RPUSH', ['Viewer:Item:' . $jobitem->id, $user->id]);
      Redis::command('LTRIM', ['Viewer:Item:' . $jobitem->id, 0, 999]);

      $this->JobItem->calcRecommend();
      $recommendJobIds = $this->JobItem->getRecommendJobList($jobitem->id);

      if ($recommendJobIds != []) {
        $recommendJobList = $this->JobItem->find($recommendJobIds);
      }
      $exists = $user->existsAppliedJobItem($jobitem->id);
    }

    $this->JobItemService->createRecentJobItemIdList($jobitem->id);

    if ($jobitem->status == 2) {
      return view('front.jobs.show', compact('jobitem', 'exists', 'recommendJobList'));
    }

    return redirect()->to('/');
  }

  // 最近見た求人リスト
  public function indexHistory()
  {
    $jobitems = $this->JobItemService->listRecentJobItemId(1);

    return view('front.jobs.history', compact('jobitems'));
  }

  // 最近見た求人のリストを返す
  public function postJobHistory(Request $request)
  {
    $jobs = $this->JobItemService->listRecentJobItemId(0);

    return response()->json($jobs);
  }

  public function search(Request $request)
  {

    $searchParam = $request->all();
    $categories = $this->CategoryRepository->getCategories();

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

    $query = $this->JobItemSearchService->search($searchParam);

    $totalJobItem = $query->count();
    $jobitems = $query->paginate(20);

    if ($request->get('page') > $jobitems->LastPage()) {
      abort(404);
    }

    $hash = array(
      'jobitems' => $jobitems,
      'jobCount' => $totalJobItem,
      'categories' => $categories,
      'searchParam' => $searchParam
    );

    return view('front.jobs.search')->with($hash);
  }

  // public function realSearchJob(Request $request)
  // {
  //   $searchParam = $request->all();
  //   $query = $this->JobItemSearchService->search($searchParam);

  //   $jobCount = $query->count();

  //   return response()->json($jobCount);
  // }
}
