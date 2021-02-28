<?php


namespace App\Http\Controllers\Employer;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Apply;
use App\Models\AchieveRewardBilling;
use App\Services\JobItemService;
use App\Services\S3Service;
use App\Repositories\CategoryRepository;
use App\Repositories\ApplyRepository;
use App\Mail\Employer\ApplyReport;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Employer\Apply\UpdateApplyReportRequest;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
  private $employer;
  private $JobItemService;
  private $S3Service;
  private $CategoryRepository;
  private $applyRepository;
  private $achieveRewardBilling;

  /**
   * ApplicationController constructor.
   */
  public function __construct(
    JobItemService $jobItemService,
    S3Service $s3Service,
    ApplyRepository $applyRepository,
    CategoryRepository $categoryRepository,
    AchieveRewardBilling $achieveRewardBilling
  ) {
    $this->JobItemService = $jobItemService;
    $this->S3Service = $s3Service;
    $this->CategoryRepository = $categoryRepository;
    $this->applyRepository = $applyRepository;
    $this->achieveRewardBilling = $achieveRewardBilling;

    $this->middleware(function ($request, $next) {
      $this->employer = \Auth::user('employer');

      return $next($request);
    });
  }

  public function index(Request $request)
  {
    $query = $this->applyRepository
      ->getAppliedForEmployer($this->employer)
      ->whereIn('e_recruit_status', [0, 1])
      ->sort(function ($first, $second) {
        if ($first->read === $second->read) {
          if ($first->e_recruit_status === $second->e_recruit_status) {
            return $first->created_at < $second->created_at ? 1 : -1;
          }
          return $first->e_recruit_status > $second->e_recruit_status ? 1 : -1;
        }
        return $first->read > $second->read ? 1 : -1;
      })
      ->filter(function ($apply) {
        return $apply->IsWithinHalfYear;
      });

    $data = [
      'unread' => $query->where('read', 0)->count(),
      'untreated' => $query->where('e_recruit_status', 0)->count()
    ];

    $applies = $this->applyRepository->paginateArrayResults($query->all(), 20);

    if ($request->input('page') > $applies->LastPage()) {
      abort(404);
    }

    return view('companies.application.index', compact('applies', 'data'));
  }

  public function show(Apply $apply)
  {
    $this->authorize('viewEmployer', $apply);

    if ($apply->read === 0) {
      $apply->update(['read' => 1]);
    }

    return view('companies.application.show', compact('apply'));
  }

  public function showReportForm(Request $request, Apply $apply)
  {
    $this->authorize('viewEmployer', $apply);
    $type = $request->input('type');

    if ($type == 'adopt' || $type == 'unadopt' || $type == 'decline') {
      return view('companies.application.report_' . $type, compact('apply'));
    }

    abort(404);
  }

  public function updateReport(UpdateApplyReportRequest $request, Apply $apply)
  {
    $this->authorize('updateEmployer', $apply);

    if ($apply->IsWithinHalfYear === false) {
      return redirect()->back();
    }

    $input = $request->input('data.apply');
    $pushed = $request->input('data.Apply.pushed');
    $data = [];
    $message = '';
    $mail = '';
    $flag = '';

    if ($pushed == 'SaveAdoptStatus') {
      $data = [
        'e_first_attendance' => $input['year'] && $input['month'] && $input['date'] ? Carbon::create(
          $input['year'],
          $input['month'],
          $input['date']
        ) : null,
        'e_nofirst_attendance' => $input['e_nofirst_attendance'],
        'e_recruit_status' => 1,
        'recruitment_status' => 2,
      ];
      $flag = 'adopt';
      $message = '採用を決定しました';
      if( $this->achieveRewardBilling->where("apply_id", $apply->id)->count() == 0 ) {
          $this->achieveRewardBilling->create([
              'apply_id' => $apply->id,
              'is_payed' => false
          ]);
      }
    } elseif ($pushed == 'SaveUnAdoptStatus') {
      $data = [
        'e_recruit_status' => 2,
        'recruitment_status' => 0,
      ];
      $flag = 'unadopt';
      $message = '不採用を通知しました';
      $mail = $request->input('data.apply.mail');
    } elseif ($pushed == 'SaveDeclineStatus') {
      $data = [
        'e_recruit_status' => 8,
        'recruitment_status' => 0,
      ];


      $flag = $request->input('data.decline.flag');
      $message = '辞退を通知しました';
      $mail = $request->input('data.decline.text');
    }
    $apply->update($data);

    if ($apply->user && ($request->has('data.is_sendable') && $pushed == 'SaveAdoptStatus') || (!$request->has('data.is_sendable') && $pushed != 'SaveAdoptStatus')) {
      Mail::to($apply->user->email)->queue(new ApplyReport($apply, $flag, $mail));
    }

    return redirect()->back()->with('flash_message_success', $message);
  }

  public function updateAchieveReward(Apply $apply)
  {
      $reward = $this->achieveRewardBilling->where("apply_id", $apply->id)->first();
      $reward->update(['is_payed' => true, 'payed_at' => date("Y-m-d H:i:s")]);
      return redirect()->back()->with('flash_message_success', '成果報酬を支払い済みに変更しました。');
  }

  public function getUnadoptOrDecline()
  {
    $query = $this->applyRepository
      ->getAppliedForEmployer($this->employer)
      ->whereIn('e_recruit_status', [2, 8])
      ->sortByDesc('created_at')
      ->filter(function ($apply) {
        return $apply->IsWithinHalfYear;
      });

    $applies = $this->applyRepository->paginateArrayResults($query->all(), 3);

    return view('companies.application.get_unadopt_or_decline', compact('applies'));
  }
}
