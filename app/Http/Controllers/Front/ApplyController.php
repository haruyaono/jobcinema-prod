<?php


namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Job\Users\User;
use App\Job\Users\Repositories\UserRepository;
use App\Job\Profiles\Profile;
use App\Job\JobItems\JobItem;
use App\Job\Applies\Apply;
use App\Mail\JobAppliedSeeker;
use App\Mail\JobAppliedEmployer;
use Illuminate\Support\Facades\Mail;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Job\Applies\Repositories\Interfaces\ApplyRepositoryInterface;
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
   * @var UserRepositoryInterface
   */
  private $userRepo;

  private $job_form_session = 'count';

  /**
   * ApplyController constructor.
   * @param ApplyRepositoryInterface $applyRepository
   * @param JobItemRepositoryInterface $jobItemRepository
   * @param UserRepositoryInterface $userRepository
   */
  public function __construct(
    ApplyRepositoryInterface $applyRepository,
    JobItemRepositoryInterface $jobItemRepository,
    UserRepositoryInterface $userRepository
  ) {
    $this->applyRepo = $applyRepository;
    $this->jobItemRepo = $jobItemRepository;
    $this->userRepo = $userRepository;
  }

  public function getApplyStep1($id, Apply $apply)
  {
    $jobitem = $this->jobItemRepo->findJobItemById($id);

    if (Auth::check()) {
      $user = $this->userRepo->findUserById(auth()->user()->id);
    } else {
      $user = '';
    }


    if ($user) {
      $profile = Profile::where('user_id', $user->id)->first();
      $postcode = str_replace("-", "", $postcode = $profile['postcode']);
      $postcode1 = substr($postcode, 0, 3);
      $postcode2 = substr($postcode, 3);
    }

    return view('jobs.apply_step1', compact('user', 'jobitem', 'postcode1', 'postcode2'));
  }

  public function postApplyStep1(ApplyRequest $request, $id)
  {

    $request->session()->put('jobapp_data', $request->all());

    return redirect()->action('Front\ApplyController@getApplyStep2', ['id' => $id]);
  }

  public function getApplyStep2($id)
  {

    $jobitem = $this->jobItemRepo->findJobItemById($id);

    return view('jobs.apply_step2', compact('jobitem'));
  }

  public function postApplyStep2(Request $request, $id)
  {

    $jobitem = $this->jobItemRepo->findJobItemById($id);
    $user = $this->userRepo->findUserById(auth()->user()->id);

    $userRepo = new UserRepository($user);
    $existsAppliedJob = $userRepo->existsAppliedJobItem($user, $id);

    if ($existsAppliedJob) {
      return view('errors.custom')->with('error_name', 'NotAppliedJob');
    }

    $jobAppData = $request->session()->get('jobapp_data');

    $company = $jobitem->company;
    $employer = $jobitem->employer;

    $applyData = [
      'user_id' => $user->id,
      'last_name' => $jobAppData['last_name'],
      'first_name' => $jobAppData['first_name'],
      'postcode' => $jobAppData['zip31'] . "-" . $jobAppData['zip32'],
      'prefecture' => $jobAppData['pref31'],
      'city' => $jobAppData['addr31'],
      'gender' => $jobAppData['gender'],
      'age' => $jobAppData['age'],
      'phone1' => $jobAppData['phone1'],
      'phone2' => $jobAppData['phone2'],
      'phone3' => $jobAppData['phone3'],
      'occupation' => $jobAppData['occupation'],
      'final_education' => $jobAppData['final_education'],
      'work_start_date' => $jobAppData['work_start_date'],
      'job_msg' => $jobAppData['job_msg'] ? $jobAppData['job_msg'] : null,
      'job_q1' => array_key_exists('job_q1', $jobAppData) ? $jobAppData['job_q1'] : null,
      'job_q2' => array_key_exists('job_q2', $jobAppData) ? $jobAppData['job_q2'] : null,
      'job_q3' => array_key_exists('job_q3', $jobAppData) ? $jobAppData['job_q3'] : null,
    ];

    $this->applyRepo->createApply($applyData, $id);

    Mail::to($user->email)->queue(new JobAppliedSeeker($jobitem, $jobAppData, $company, $employer));
    Mail::to($employer->email)->queue(new JobAppliedEmployer($user, $jobitem, $jobAppData, $company, $employer));

    return redirect()->action('Front\ApplyController@completeJobApply', ['id' => $id]);
  }

  public function completeJobApply($id)
  {

    $jobitem = $this->jobItemRepo->findJobItemById($id);

    return view('jobs.apply_complete', compact('jobitem'));

    session()->forget('jobapp_data');
  }
}
