<?php

namespace App\Http\Controllers\Employer;

use App\Models\JobItem;
use App\Services\JobItemService;
use App\Services\S3Service;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Employer\JobItem\JobCreateStep1Request;
use App\Http\Requests\Employer\JobItem\JobCreateTmpSaveOrConfirmRequest;
use App\Http\Requests\Employer\JobItem\JobSheetUpdateCategoryRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class JobItemController extends Controller
{

  private $employer;
  private $JobItemService;
  private $S3Service;
  private $CategoryRepository;

  public function __construct(
    JobItemService $jobItemService,
    S3Service $s3Service,
    CategoryRepository $categoryRepository
  ) {
    $this->JobItemService = $jobItemService;
    $this->S3Service = $s3Service;
    $this->CategoryRepository = $categoryRepository;

    $this->middleware(function ($request, $next) {
      $this->employer = \Auth::user('employer');

      return $next($request);
    });
  }

  public function index(Request $request)
  {
    $jobitems = $this->employer->jobitems()->acriveForEmpJobitems()->orderBy('created_at', 'asc')->paginate(20);

    if ($request->get('page') > $jobitems->LastPage()) {
      abort(404);
    }

    return view('companies.jobs.index', compact('jobitems'));
  }

  public function editCategory(Request $request, JobItem $jobitem, $cat_slug)
  {
    $this->authorize('view', $jobitem);

    $categories = $this->CategoryRepository->getCategoriesByslug($cat_slug);

    return view('companies.job_sheet.edit_category', compact('jobitem', 'cat_slug', 'categories'));
  }

  public function updateCategory(JobSheetUpdateCategoryRequest $request, JobItem $jobitem)
  {
    $this->authorize('update', $jobitem);

    if ($jobitem->id !== (int) $request->input('data.JobSheet.id')) {
      return redirect()->back();
    }

    $categoryFlag = $request->input('cat_flag');

    $saveCategoryList = $jobitem->categories()->wherePivot('ancestor_slug', $categoryFlag)->get(['job_item_category.category_id']);

    if (!$saveCategoryList->isEmpty()) {
      foreach ($saveCategoryList as $saveCategoryItem) {
        $jobitem->categories()->detach($saveCategoryItem->category_id);
      }
    }

    $categoryData = $request->input('data.JobSheet.categories');
    $createData = $this->JobItemService->processingCategoryArrayForUpdate($categoryData, $categoryFlag);

    $categorySalarySlug = $categoryFlag == 'salary' ? array_column($createData, 'parent_slug') : [];

    foreach ($createData as $createItem) {
      $this->JobItemService->associateCategory($jobitem->id, $createItem);
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
    $categoryList = $this->CategoryRepository->getCategories();

    if (preg_match("/iPhone|iPod|Android.*Mobile|Windows.*Phone/", $_SERVER['HTTP_USER_AGENT'])) {
      return view('companies.job_sheet.create_step1_sp', compact('categoryList'));
    } else {
      return view('companies.job_sheet.create_step1', compact('categoryList'));
    }
  }

  public function storeStep1(JobCreateStep1Request $request)
  {
    $company =  $this->employer->company;
    $categoryData = $request->input('data.JobSheet.categories');

    $createData = $this->JobItemService->processingCategoryArray($categoryData);

    $data = [
      'status' => 99,
      'company_id' => $company->id
    ];

    $created = DB::transaction(function () use ($createData, $data) {

      $created = JobItem::create($data);

      foreach ($createData as $createItem) {
        $this->JobItemService->associateCategory($created->id, $createItem);
      }

      return $created;
    });

    return redirect()->route('edit.jobsheet.step2', [$created]);
  }

  public function editStep2(Request $request, JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);

    $editFlag = (int) $request->input('edit');
    $imageArray = $this->S3Service->getJobItemImagePublicUrl($jobitem);
    $movieArray = $this->S3Service->getJobItemMoviePublicUrl($jobitem);

    return view('companies.job_sheet.create_step2', compact('jobitem', 'imageArray', 'movieArray', 'editFlag'));
  }

  public function storeDraftOrConfirm(JobCreateTmpSaveOrConfirmRequest $request, JobItem $jobitem)
  {
    $this->authorize('update', $jobitem);
    $company = $this->employer->company;

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

      $request['status'] = 0;

      $jobitem->update($request);

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

    $imageArray = $this->S3Service->getJobItemImagePublicUrl($jobitem);
    $movieArray = $this->S3Service->getJobItemMoviePublicUrl($jobitem);

    return view('companies.job_sheet.confirm', compact('jobitem', 'imageArray', 'movieArray'));
  }

  public function updateStep2(Request $request, JobItem $jobitem)
  {
    $this->authorize('update', $jobitem);
    $data = $request->session()->get('data.JobSheet');

    if (!$data || $jobitem->id !== (int) $data['id']) {
      return redirect()->route('index.company.mypage');
    }

    unset($data['id']);

    if ($jobitem->status !== 2) {
      $data['status'] = 1;
    }

    $jobitem->update($data);

    $request->session()->forget('data');

    return view('companies.job_sheet.create_complete', compact('jobitem'));
  }

  public function show(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);

    $company = $this->employer->company;
    $imageArray = $this->S3Service->getJobItemImagePublicUrl($jobitem);
    $movieArray = $this->S3Service->getJobItemMoviePublicUrl($jobitem);

    return view('companies.job_sheet.show', compact('jobitem', 'company', 'imageArray', 'movieArray'));
  }
}
