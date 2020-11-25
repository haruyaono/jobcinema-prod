<?php


namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobItem;
use App\Models\Apply;
use App\Models\ApplyDetail;
use App\Mail\JobAppliedSeeker;
use App\Mail\JobAppliedEmployer;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Front\ApplyRequest;
use App\Http\Controllers\Controller;

class ApplyController extends Controller
{

  private $user;

  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $this->user = \Auth::guard('seeker')->user();

      return $next($request);
    });
  }

  public function showStep1(JobItem $jobitem, Apply $apply)
  {
    $postcode = [];
    $user = $this->user;

    if ($user) {
      $postcode = explode("-", $user->profile->postcode);
    }

    return view('front.applies.show_step1', compact('user', 'jobitem', 'postcode'));
  }

  public function storeStep1(ApplyRequest $request, JobItem $jobitem)
  {

    $request->session()->put('front.data.entry', $request->input('data.apply'));

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

    if ($this->user->existsAppliedJobItem($jobitem->id)) {
      return view('errors.custom')->with('error_name', 'NotAppliedJob');
    }

    $data = [
      'user_id' => $this->user->id,
      'job_item_id' => $jobitem->id,
      'congrats_amount' => $jobitem->existsCongratsMoney() ? $jobitem->getCongratsMoney()->amount : 0,
      'congrats_status' => $jobitem->existsCongratsMoney() ? 1 : 0,
      'congrats_application_status' => 0,
      'recruitment_fee' => $jobitem->getAchivementRewardMoneyAmount(),
      'recruitment_status' => 1,
    ];

    $created = Apply::create($data);

    $detailData = $request->session()->get('front.data.entry');
    $detailData['apply_id'] = $created->id;
    $detailData['postcode'] = $detailData['postcode01'] . "-" . $detailData['postcode02'];
    unset($detailData['postcode01'], $detailData['postcode02']);

    ApplyDetail::create($detailData);

    $employer = $jobitem->company->employer;
    $detailData['email'] = $this->user->email;

    Mail::to($this->user->email)->queue(new JobAppliedSeeker($jobitem, $detailData));
    Mail::to($employer->email)->queue(new JobAppliedEmployer($jobitem, $detailData));

    return redirect()->route('show.front.entry.finish', ['jobitem' => $jobitem]);
  }

  public function showFinish(Request $request, JobItem $jobitem)
  {
    if (!$this->user->existsAppliedJobItem($jobitem->id)) {
      return redirect('/');
    }
    $request->session()->forget('front.data.entry');
    return view('front.applies.show_finish', compact('jobitem'));
  }
}
