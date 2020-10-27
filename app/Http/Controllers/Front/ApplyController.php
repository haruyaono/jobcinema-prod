<?php


namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Job\JobItems\JobItem;
use App\Job\Applies\Apply;
use App\Mail\JobAppliedSeeker;
use App\Mail\JobAppliedEmployer;
use Illuminate\Support\Facades\Mail;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Job\Applies\Repositories\Interfaces\ApplyRepositoryInterface;
use App\Job\ApplyDetails\Repositories\Interfaces\ApplyDetailRepositoryInterface;
use App\Job\Applies\Requests\ApplyRequest;
use App\Http\Controllers\Controller;

class ApplyController extends Controller
{
  /**
   * @var JobItemRepositoryInterface
   */
  private $jobItemRepo;

  /**
   * @var ApplyRepositoryInterface
   */
  private $applyRepo;

  /**
   * @var ApplyDetailRepositoryInterface
   */
  private $applyDetailRepo;


  /**
   * @var UserRepositoryInterface
   */
  private $userRepo;

  /**
   * ApplyController constructor.
   * @param ApplyRepositoryInterface $applyRepository
   * @param ApplyDetailRepositoryInterface $applyDetailRepository
   * @param JobItemRepositoryInterface $jobItemRepository
   * @param UserRepositoryInterface $userRepository
   */
  public function __construct(
    ApplyRepositoryInterface $applyRepository,
    ApplyDetailRepositoryInterface $applyDetailRepository,
    JobItemRepositoryInterface $jobItemRepository,
    UserRepositoryInterface $userRepository
  ) {
    $this->applyRepo = $applyRepository;
    $this->applyDetailRepo = $applyDetailRepository;
    $this->jobItemRepo = $jobItemRepository;
    $this->userRepo = $userRepository;
  }

  public function showStep1(JobItem $jobitem, Apply $apply)
  {
    if (Auth::check()) {
      $user = $this->userRepo->findUserById(auth()->user()->id);
    } else {
      $user = '';
    }

    if ($user) {
      $postcode = explode("-", $user->profile->postcode);
    }

    return view('front.applies.show_step1', compact('user', 'jobitem', 'postcode'));
  }

  public function storeStep1(ApplyRequest $request, JobItem $jobitem)
  {

    $request->session()->put('front.data.entry', $request->all());

    return redirect()->route('show.front.entry.step2', ['jobitem' => $jobitem]);
  }

  public function showStep2(JobItem $jobitem)
  {
    if (!session()->has('front.data.entry')) {
      return redirect('/');
    }
    return view('front.applies.show_step2', compact('jobitem'));
  }

  public function storeStep2(Request $request, JobItem $jobitem)
  {
    if (!$request->session()->has('front.data.entry')) {
      return redirect('/');
    }
    $user = $this->userRepo->findUserById(auth()->user()->id);

    if ($user->applies()->where('job_item_id', $jobitem->id)->exists()) {
      return view('errors.custom')->with('error_name', 'NotAppliedJob');
    }

    $data = [
      'user_id' => $user->id,
      'job_item_id' => $jobitem->id,
      'congrats_amount' => $jobitem->getCongratsMoneyAmount(),
      'congrats_status' => 2,
      'recruitment_fee' => $jobitem->getAchivementRewardMoneyAmount(),
      'recruitment_status' => 2,
    ];

    $created = $this->applyRepo->createApply($data);

    $detailData = $request->session()->get('front.data.entry');
    $detailData['apply_id'] = $created->id;
    $detailData['postcode'] = $detailData['zip31'] . "-" . $detailData['zip32'];
    $detailData['prefecture'] = $detailData['pref31'];
    $detailData['city'] = $detailData['addr31'];
    unset($detailData['_token'], $detailData['zip31'], $detailData['zip32'], $detailData['pref31'], $detailData['addr31']);

    $this->applyDetailRepo->createApplyDetail($detailData);

    $employer = $jobitem->company->employer;

    $detailData['email'] = $user->email;

    Mail::to($user->email)->queue(new JobAppliedSeeker($jobitem, $detailData));
    Mail::to($employer->email)->queue(new JobAppliedEmployer($jobitem, $detailData));

    return redirect()->route('show.front.entry.finish', ['jobitem' => $jobitem]);
  }

  public function showFinish(Request $request, JobItem $jobitem)
  {
    $user = $this->userRepo->findUserById(auth()->user()->id);
    if (!$user->applies()->where('job_item_id', $jobitem->id)->exists()) {
      return redirect('/');
    }
    $request->session()->forget('front.data.entry');
    return view('front.applies.show_finish', compact('jobitem'));
  }
}
