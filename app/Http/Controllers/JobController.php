<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Job\Profiles\Repositories\ProfileRepository;
use App\Job\JobItems\JobItem;
use App\Job\JobItems\Repositories\JobItemRepository;
use App\Job\JobItems\Requests\JobCreateStep1Request;
use App\Job\JobItems\Requests\JobCreateTmpSaveOrConfirmRequest;
use App\Job\JobItems\Requests\JobSheetUpdateCategoryRequest;
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

    foreach ($jobItems as $jobitem) {
      if ($jobitem->applies->count() === 0) {
        continue;
      }

      $applyJobList[$jobitem->id] = [];

      foreach ($jobitem->applies as $key => $apply) {
        if ($apply->user === null) {

          if ($jobitem->applies->count() === 1) {
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
    if ($applyInfo['jobitem'] === null) {
      return view('errors.employer.custom')->with('error_name', 'NotJobItem');
    }

    $applyInfo['jobAppliedInfo'] = $applyInfo['jobitem']->applies()
      ->wherePivot('apply_id', $applyId)
      ->wherePivot('job_item_id', $applyInfo['jobitem']->id)
      ->first();

    if ($applyInfo['jobAppliedInfo'] === null) {
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

  public function index(Request $request)
  {
    $list = $this->employerRepo->findJobItems($request->user())->sortBy('created_at')->all();
    $jobitems = $this->jobItemRepo->paginateArrayResults($list, 10);

    if (Input::get('page') > $jobitems->LastPage()) {
      abort(404);
    }

    return view('companies.jobs.index', compact('jobitems'));
  }

  public function editCategory(Request $request, JobItem $jobitem, $cat_slug)
  {
    $this->authorize('view', $jobitem);

    $categories = $this->categoryRepo->listCategoriesByslug($cat_slug);

    return view('companies.job_sheet.edit_category', compact('jobitem', 'cat_slug', 'categories'));
  }

  public function updateCategory(JobSheetUpdateCategoryRequest $request, JobItem $jobitem)
  {
    $this->authorize('update', $jobitem);

    if ($jobitem->id !== (int) $request->input('data.JobSheet.id')) {
      return redirect()->back();
    }

    $categoryFlag = $request->input('cat_flag');

    $jobItemRepo = new JobItemRepository($jobitem);

    $saveCategoryList = $jobitem->categories()->wherePivot('ancestor_slug', $categoryFlag)->get();

    if (!$saveCategoryList->isEmpty()) {
      foreach ($saveCategoryList as $saveCategoryItem) {
        $jobItemRepo->dissociateCategory($saveCategoryItem->id);
      }
    }

    $categoryData = $request->input('data.JobSheet.categories');
    $categorySalarySlug = [];
    $newData = [];

    if ($categoryFlag == 'salary') {
      foreach ($categoryData[$categoryFlag] as $key => $data) {
        if (!array_key_exists('id', $data)) {
          $category = $this->categoryRepo->findCategoryBySlig($data['parent_slug']);
          $data['id'] = $category->descendants()->where('slug', 'unregistered')->first()->id;
          $data['parent_id'] = $category->id;
        }
        $newData = [
          'id' => $data['id'],
          'ancestor_id' => $categoryData['salary_ancestor']['id'],
          'ancestor_slug' => $categoryData['salary_ancestor']['slug'],
          'parent_id' =>  $data['parent_id'],
          'parent_slug' => $data['parent_slug'],
        ];

        $jobItemRepo->associateCategory($newData);
        array_push($categorySalarySlug, $this->categoryRepo->findCategoryById($data['parent_id'])->slug);
      }
    } else {
      $newData = [
        'id' => $categoryData[$categoryFlag]['id'],
        'ancestor_id' => $categoryData[$categoryFlag]['ancestor_id'],
        'ancestor_slug' => $categoryData[$categoryFlag]['ancestor_slug'],
      ];
      $jobItemRepo->associateCategory($newData);
    }

    $categories = $jobitem->categories()->wherePivot('ancestor_slug', $categoryFlag)->get();

    return view('companies.job_sheet.edit_category_complete', compact('categories', 'categoryFlag', 'categorySalarySlug'));
  }

  public function createTop()
  {
    return view('companies.job_sheet.top_create');
  }

  public function createStep1()
  {
    $categoryList = $this->categoryRepo->listCategories('sort', 'asc');
    if (preg_match("/iPhone|iPod|Android.*Mobile|Windows.*Phone/", $_SERVER['HTTP_USER_AGENT'])) {
      return view('companies.job_sheet.create_step1_sp', compact('categoryList'));
    } else {
      return view('companies.job_sheet.create_step1', compact('categoryList'));
    }
  }

  public function storeStep1(JobCreateStep1Request $request)
  {
    $employer = auth('employer')->user();
    $company =  $employer->company;
    $categoryData = $request->input('data.JobSheet.categories');

    foreach ($categoryData as $key => $data) {
      $arr = [];
      if ($key == 'salary') {
        foreach ($categoryData[$key] as $data) {
          if (!array_key_exists('id', $data)) {
            $category = $this->categoryRepo->findCategoryBySlig($data['parent_slug']);
            $data['id'] = $category->descendants()->where('slug', 'unregistered')->first()->id;
            $data['parent_id'] = $category->id;
          }
          array_push($arr, [
            'id' => $data['id'],
            'ancestor_id' => $categoryData['salary_ancestor']['id'],
            'ancestor_slug' => $categoryData['salary_ancestor']['slug'],
            'parent_id' =>  $data['parent_id'],
            'parent_slug' => $data['parent_slug'],
          ]);
        }

        $categoryData = array_merge($categoryData, $arr);
        unset($categoryData[$key]);
        unset($categoryData['salary_ancestor']);
        continue;
      }
      if (!array_key_exists('salary_ancestor', $categoryData)) {
        continue;
      }
      $arr = [
        'id' => $categoryData[$key]['id'],
        'ancestor_id' => $categoryData[$key]['ancestor_id'],
        'ancestor_slug' => $categoryData[$key]['ancestor_slug'],
      ];
      $categoryData[$key] = $arr;
    }

    $data = [
      'status' => 99,
      'company_id' => $company->id
    ];

    $created = $this->jobItemRepo->createJobItem($data);

    $jobItemRepo = new JobItemRepository($created);
    foreach ($categoryData as $categoryItem) {
      $jobItemRepo->associateCategory($categoryItem);
    }

    return redirect()->route('edit.jobsheet.step2', [$created]);
  }

  public function editStep2(Request $request, JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);

    $editFlag = (int) $request->input('edit');
    $jobitem = $this->jobItemRepo->findAllJobItemById($jobitem->id);
    $jobBaseUrl = $this->jobItemRepo->getJobBaseUrl();

    return view('companies.job_sheet.create_step2', compact('jobitem', 'jobBaseUrl', 'editFlag'));
  }

  public function storeDraftOrConfirm(JobCreateTmpSaveOrConfirmRequest $request, JobItem $jobitem)
  {
    $this->authorize('update', $jobitem);

    $employer = auth('employer')->user();
    $company = $employer->company;

    $request = $request->input('data.JobSheet');
    $request['pub_start_flag'] = (int) $request['pub_start_flag'];
    $request['pub_end_flag'] = (int) $request['pub_end_flag'];

    if ($jobitem->id !== (int) $request['id']) {
      return redirect()->back();
    }

    if ($request['pushed'] === "SaveTmpJob") {
      unset($request['pushed'], $request['id']);

      if ($request['pub_start_flag'] === 0 && !array_key_exists('pub_start_date', $request)) {
        $request['pub_start_date'] = null;
      }
      if ($request['pub_end_flag'] === 0 && !array_key_exists('pub_end_date', $request)) {
        $request['pub_end_date'] = null;
      }

      $jobItemRepo = new JobItemRepository($jobitem);

      $request['status'] = 0;

      $jobItemRepo->updatejobItem($request);

      return view('companies.job_sheet.create_tmp_complete');
    } elseif ($request['pushed'] === "SaveJob") {

      unset($request['pushed']);
      session()->put('data.JobSheet', $request);

      return redirect()->route('show.jobsheet.step2.confirm', compact('jobitem'));
    }
  }

  public function showStep2Confirm(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);

    $data = session()->get('data.JobSheet');

    if (!$data || $jobitem->id !== (int) $data['id']) {
      return redirect()->route('index.jobsheet.top');
    }

    $jobBaseUrl = $this->jobItemRepo->getJobBaseUrl();
    return view('companies.job_sheet.confirm', compact('jobitem', 'jobBaseUrl'));
  }

  public function updateStep2(Request $request, JobItem $jobitem)
  {
    $this->authorize('update', $jobitem);

    $data = $request->session()->get('data.JobSheet');

    if (!$data || $jobitem->id !== (int) $data['id']) {
      return redirect()->route('index.company.mypage');
    }

    unset($data['id']);

    $jobItemRepo = new JobItemRepository($jobitem);

    if ($jobitem->status !== 2) {
      $data['status'] = 1;
    }

    $jobItemRepo->updatejobItem($data);

    $updated = $this->jobItemRepo->findAllJobItemById($jobitem->id);

    $request->session()->forget('data');

    return view('companies.job_sheet.create_complete', compact('updated'));
  }

  public function show(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $company = auth('employer')->user()->company;
    $jobBaseUrl = $this->jobItemRepo->getJobBaseUrl();

    return view('companies.job_sheet.show', compact('jobitem', 'company', 'jobBaseUrl'));
  }
}
