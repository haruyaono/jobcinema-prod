<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobItem;

class DashboardController extends Controller
{
    private $jobitem;

    /**
     * DashboardController constructor.
     * @param JobItem $jobItem
     */
    function __construct(
        JobItem $jobitem
    ) {
        $this->jobitem = $jobitem;
    }

    public function index()
    {
        return view('admin.top');
    }


    // public function getAllJobs()
    // {
    //     $data = [];
    //     $param = request()->all();

    //     if (request()->has('status') && request()->input('status') != '') {
    //         $data = array_merge($data, array('status' => request()->input('status')));
    //     }

    //     if (request()->has('oiwaikin') && request()->input('oiwaikin') != '') {
    //         $oiwaikin_q = request()->input('oiwaikin');
    //         if ($oiwaikin_q == "3000") {
    //             $oiwaikin_q  = intval($oiwaikin_q);
    //         } elseif ($oiwaikin_q == "not") {
    //             $oiwaikin_q = null;
    //         }
    //         $data = array_merge($data, array('oiwaikin' => $oiwaikin_q));
    //     }
    //     if (request()->has('created_at') && request()->input('created_at') != '') {
    //         $list = $this->jobItemRepo->searchJobItem($data, 'created_at', request()->input('created_at'));
    //     } else {
    //         $list = $this->jobItemRepo->searchJobItem($data, 'created_at', 'desc');
    //     }

    //     return view('admin.alljob', [
    //         'jobs' => $this->jobItemRepo->paginateArrayResults($list->all(), 10),
    //         'param' => $param
    //     ]);
    // }

    // public function getJobDetail($id)
    // {
    //     $job = $this->jobItemRepo->findAllJobItemById($id);

    //     return view('admin.job_detail', compact('job'));
    // }

    // public function oiwaikinChange($id)
    // {
    //     $job = $this->jobItemRepo->findAllJobItemById($id);
    //     $jobItemRepo = new JobItemRepository($job);

    //     $data = [
    //         'oiwaikin' => ''
    //     ];
    //     if ($job->oiwaikin === null) {
    //         $data['oiwaikin'] = config('const.OIWAIKIN_AMOUNT');
    //     } else {
    //         $data['oiwaikin'] = null;
    //     }
    //     $jobItemRepo->updateJobItem($data);

    //     return redirect()->back()->with('message', 'お祝い金設定を変更しました');
    // }

    // public function getApprovalPendingJobs()
    // {
    //     $list = $this->jobItemRepo->findBy(['status' => 1])->sortByDesc('created_at');

    //     return view('admin.approval_pending_job', [
    //         'jobs' => $this->jobItemRepo->paginateArrayResults($list->all(), 10),
    //     ]);
    // }

    // public function approveJobStatus($id, $slug)
    // {
    //     $job = $this->jobItemRepo->findAllJobItemById($id);
    //     $employer = $job->employer;

    //     $jobItemRepo = new JobItemRepository($job);

    //     switch ($slug) {
    //         case 'status_approve':
    //             $jobItemRepo->updateJobItem(['status' => 2]);
    //             $message['message'] = '【求人(' . $job->id . ')】を承認しました';
    //             break;
    //         case 'status_non_approve':
    //             $jobItemRepo->updateJobItem(['status' => 3]);
    //             $message['message'] = '【求人(' . $job->id . ')】を非承認にしました';
    //             break;
    //         case 'status_non_public':
    //             $jobItemRepo->updateJobItem(['status' => 6]);
    //             $message['message'] = '【求人(' . $job->id . ')】を完全非公開にしました';
    //             break;
    //     }
    //     $this->adminRepo->sendEmailToEmployer($job, $slug);

    //     return redirect()->back()->with($message);
    // }

    // public function jobDetete($id)
    // {
    //     $disk = Storage::disk('s3');
    //     $job = $this->jobItemRepo->findAllJobItemById($id);

    //     $dirList['image'] = \Config::get('fpath.real_img') . $job->id;
    //     $dirList['movie'] = \Config::get('fpath.real_mov') . $job->id;

    //     foreach ($dirList as $dKey => $dir) {
    //         File::deleteDirectory(public_path() . $dirList[$dKey]);
    //         $disk->deleteDirectory($dirList[$dKey]);
    //     }

    //     DB::beginTransaction();
    //     try {

    //         if ($job->applies()->exists()) {
    //             $job->applies()->detach();
    //         }
    //         if ($job->favourites()->exists()) {
    //             $job->favourites()->detach();
    //         }

    //         $job->delete();

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //     }

    //     return redirect()->back()->with('message', '求人削除しました');
    // }

    // public function getAppManage()
    // {
    //     $app_list = DB::table('apply_job_item')
    //         ->select('apply_job_item.id as apply_job_item_id', 'apply_job_item.job_item_id', 'apply_job_item.apply_id', 'apply_job_item.s_status', 'apply_job_item.e_status', 'apply_job_item.created_at', 'applies.user_id', 'applies.last_name', 'applies.first_name')
    //         ->leftJoin('applies', 'apply_job_item.apply_id', 'applies.id')
    //         ->latest()
    //         ->paginate(10);

    //     return view('admin.app_list', compact('app_list'));
    // }

    // public function getOiwaikinUsers()
    // {
    //     $oiwaikin_users = DB::table('apply_job_item')
    //         ->whereNotNull('oiwaikin')
    //         ->whereNotNull('first_attendance')
    //         ->select('apply_job_item.id as apply_job_item_id', 'apply_job_item.job_item_id', 'apply_job_item.apply_id', 'apply_job_item.s_status', 'apply_job_item.e_status', 'apply_job_item.oiwaikin', 'apply_job_item.first_attendance', 'apply_job_item.created_at', 'applies.user_id', 'applies.last_name', 'applies.first_name')
    //         ->leftJoin('applies', 'apply_job_item.apply_id', 'applies.id')
    //         ->latest()
    //         ->paginate(10);

    //     return view('admin.oiwaikin_users', compact('oiwaikin_users'));
    // }

    // public function getUserDetail($id)
    // {
    //     $apply = $this->applyRepo->findApplyById($id);

    //     if (!$apply->user) {
    //         return view('errors.admin.custom')->with('error_name', 'NotUser');
    //     }
    //     foreach ($apply->jobItems as $jobItem) {
    //         $applyJobItem = $jobItem;
    //     }

    //     $profile = $apply->user->profile;

    //     return view('admin.user_detail', compact('apply', 'applyJobItem', 'profile'));
    // }

    // public function getBilling()
    // {

    //     $month_list = $this->jobItem->getMonthList();
    //     $applyJobItemList = DB::table('apply_job_item')
    //         ->select('job_item_id', DB::raw('count(*) as tatal'))
    //         ->groupBy('job_item_id')
    //         ->get();

    //     foreach ($applyJobItemList as $applyJobItem) {
    //         $jobitem = $this->jobItemRepo->findAllJobItemById($applyJobItem->job_item_id);
    //         $employer = $jobitem->employer;
    //         if ($employer->company) {
    //             $applyJobItem->company = $employer->company;
    //         }
    //     }

    //     $applyJobItemList = $this->adminRepo->paginateArrayResults($applyJobItemList->all(), 10);

    //     return view('admin.billing_top', compact('month_list', 'applyJobItemList'));
    // }

    // public function getBillingYear(bellingParameter $request)
    // {
    //     $input = $request->input();

    //     $app_list = $this->jobItem->getAppJobList(self::NUM_PER_PAGE, $input);

    //     // ページネーションリンクにクエリストリングを付け加える
    //     $app_list->appends($input);
    //     $month_list = $this->jobItem->getMonthList()
    //         ->where('year', $input['year'])
    //         ->where('month', $input['month'])
    //         ->first();

    //     foreach ($app_list as $app_item) {
    //         $app_item->apply = $this->applyRepo->findApplyById($app_item->apply_id);
    //         $app_item->user = $app_item->apply->user;
    //     }

    //     $total = $app_list->count() * 30000;
    //     $total = number_format($total);

    //     return view('admin.billing_year', compact('app_list', 'month_list', 'total'));
    // }

    // public function getAllCompanies()
    // {
    //     $param = request()->all();
    //     $list = $this->companyRepo->listCompanies('created_at');

    //     if (request()->has('created_at') && request()->input('created_at') != '') {
    //         $list = $this->companyRepo->listCompanies('created_at', request()->input('created_at'));
    //     }

    //     if (request()->has('c_status') && request()->input('c_status') != '') {
    //         $list = $list->filter(function ($cItem, $cKey) {
    //             return $cItem->employer->status === intval(request()->input('c_status'));
    //         });
    //     }

    //     return view('admin.all_company', [
    //         'companies' => $this->companyRepo->paginateArrayResults($list->all(), 10),
    //         'param' => $param
    //     ]);
    // }

    // public function getCompanyDetail($id)
    // {
    //     $company =  $this->companyRepo->findCompanyById($id);
    //     $jobs =  $company->jobs;

    //     return view('admin.company_detail', compact('company', 'jobs'));
    // }

    // public function companyDelete($id)
    // {
    //     $company =  $this->companyRepo->findCompanyById($id);
    //     $employer = $company->employer;
    //     $jobs = $employer->jobs;

    //     $disk = Storage::disk('s3');

    //     DB::beginTransaction();
    //     try {
    //         if (!$jobs->isEmpty()) {

    //             foreach ($dirList as $dKey => $dir) {
    //                 File::deleteDirectory(public_path() . $dirList[$dKey]);
    //                 $disk->deleteDirectory($dirList[$dKey]);
    //             }

    //             foreach ($jobs as $job) {
    //                 $dirList['image'] = \Config::get('fpath.real_img') . $job->id;
    //                 $dirList['movie'] = \Config::get('fpath.real_mov') . $job->id;

    //                 foreach ($dirList as $dKey => $dir) {
    //                     File::deleteDirectory(public_path() . $dirList[$dKey]);
    //                     $disk->deleteDirectory($dirList[$dKey]);
    //                 }

    //                 if ($job->applies()->exists()) {
    //                     $job->applies()->detach();
    //                 }
    //                 if ($job->favourites()->exists()) {
    //                     $job->favourites()->detach();
    //                 }

    //                 $job->delete();
    //             }
    //         }

    //         $company->delete();
    //         $employer->delete();

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //     }

    //     return redirect()->back()->with('message', 'アカウントを削除しました');
    // }

    // public function categoryTop()
    // {
    //     return view('admin.category_top');
    // }

    // public function category($url)
    // {

    //     $catList = $this->categoryRepo->listCategoriesByslug($url);
    //     $catTitle = $catList->first()->parent->name;

    //     $arrCatList = $catList->toArray();

    //     $tn = $ts = $temp_num = $temp_str = array();

    //     if ($url === 'salary') {
    //         foreach ($arrCatList as $key => $row) {
    //             $tn = $ts = $temp_num = $temp_str = array();

    //             foreach ($row['children'] as $k => $r) {
    //                 if (is_numeric(substr($r['name'], 0, 1))) {
    //                     $tn[$k] = str_replace(',', '', $r['name']);

    //                     $temp_num[$k] = $r;
    //                 } else {
    //                     $ts[$k] = $r['name'];
    //                     $temp_str[$k] = $r;
    //                 }
    //             }

    //             array_multisort($tn, SORT_ASC, SORT_NUMERIC, $temp_num);
    //             array_multisort($ts, SORT_ASC, SORT_STRING, $temp_str);
    //             $arrCatList[$key]['children'] = array_merge($temp_num, $temp_str);
    //         }
    //     } else {
    //         foreach ($arrCatList as $key => $row) {
    //             if (is_numeric(substr($row['name'], 0, 1))) {
    //                 $tn[$key] = str_replace(',', '', $row['name']);

    //                 $temp_num[$key] = $row;
    //             } else {
    //                 $ts[$key] = $row['name'];
    //                 $temp_str[$key] = $row;
    //             }
    //         }
    //         array_multisort($tn, SORT_ASC, SORT_NUMERIC, $temp_num);
    //         array_multisort($ts, SORT_ASC, SORT_STRING, $temp_str);
    //         $arrCatList = array_merge($temp_num, $temp_str);
    //     }

    //     return view('admin.category', compact('arrCatList', 'url', 'catTitle'));
    // }

    // /**
    //  * カテゴリ編集・新規作成API
    //  *
    //  * @param AdminRequest $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function editCategory(AdminRequest $request, $flag)
    // {
    //     $category_id = $request->input('category_id');

    //     if ($category_id === null) {
    //         $parent = Category::find($request->input('pId'));
    //         $children = Category::create([
    //             'name' => $request->input('name')
    //         ]);
    //         if ($flag === 'status') {
    //             CongratsMoney::create([
    //                 'category_id' => $children->id
    //             ]);
    //             AchievementReward::create([
    //                 'category_id' => $children->id
    //             ]);
    //         }
    //         $category = $parent->appendNode($children);
    //     } else {
    //         $findCategory = Category::find($category_id);
    //         $category = $findCategory->update([
    //             'name' => $request->input('name'),
    //         ]);
    //     }

    //     return response()->json($category);
    // }

    // /**
    //  * カテゴリ削除API
    //  *
    //  * @param AdminRequest $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function deleteCategory(AdminRequest $request, $flag)
    // {
    //     $categoryId = $request->input('category_id');

    //     try {
    //         Category::destroy($categoryId);
    //     } catch (Exception $e) {
    //         return response()->json($e);
    //     }
    // }

    // public function getSettingMonies($flag)
    // {

    //     if ($flag === 'congrats') {
    //         $moniesList = CongratsMoney::all();
    //     } elseif ($flag === 'achievement_rewards') {
    //         $moniesList = AchievementReward::all();
    //     } else {
    //         return view('admin.home');
    //     }

    //     $parent = Category::where('slug', 'status')->first();
    //     $statusCategories = $parent->children();

    //     return view('admin.setting.monies', [
    //         'moniesList' => $moniesList,
    //         'statusCategories' => $statusCategories,
    //         'flag' => $flag,
    //     ]);
    // }

    // /**
    //  * お祝い金編集・新規作成API
    //  *
    //  * @param AdminRequest $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function editSettingMoney(Request $request, $flag)
    // {
    //     $request->validate([
    //         'amount' => 'required|integer',
    //         'label' => 'max:191',
    //     ]);

    //     $target_id = $request->input('target_id');

    //     try {
    //         if ($flag === 'congrats') {
    //             $targetMoney = CongratsMoney::findOrFail($target_id);
    //         } elseif ($flag === 'achievement_rewards') {
    //             $targetMoney = AchievementReward::findOrFail($target_id);
    //         } else {
    //             return redirect()->back();
    //         }
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json([
    //             'message' => '該当するデータが存在しません',
    //         ], 404);
    //     }
    //     $updated = $targetMoney->update([
    //         'amount' => $request->input('amount'),
    //         'label' => $request->input('label'),
    //     ]);

    //     return response()->json($updated);
    // }
}
