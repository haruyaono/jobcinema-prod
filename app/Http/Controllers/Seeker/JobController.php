<?php

namespace App\Http\Controllers\Seeker;

use App\Job\Applies\Apply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Job\Applies\Repositories\ApplyRepository;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\Applies\Repositories\Interfaces\ApplyRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Job\Users\Requests\UpdateApplyReportRequest;

class JobController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * @var JobItemRepositoryInterface
     */
    private $jobItemRepo;

    /**
     * @var ApplyRepositoryInterface
     */
    private $applyRepo;

    private $user;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param JobItemRepositoryInterface $jobItemRepository
     * @param ApplyRepositoryInterface $applyRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        JobItemRepositoryInterface $jobItemRepository,
        ApplyRepositoryInterface $applyRepository
    ) {
        $this->userRepo = $userRepository;
        $this->jobItemRepo = $jobItemRepository;
        $this->applyRepo = $applyRepository;

        $this->middleware(function ($request, $next) {
            $this->user = \Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $applies = $this->userRepo->findApplies($this->user)->filter(function ($apply) {
            return $apply->IsWithinHalfYear;
        });

        return view('seeker.job.index', compact('applies'));
    }

    public function showReport(Apply $apply)
    {
        $this->authorize('view', $apply);

        if ($apply->IsWithinHalfYear === false) {
            return redirect()->route('index.seeker.job');
        }

        return view('seeker.job.show_report', compact('apply'));
    }

    public function editReport(Apply $apply)
    {
        $this->authorize('view', $apply);

        if ($apply->IsWithinHalfYear === false) {
            return redirect()->route('index.seeker.job');
        }

        return view('seeker.job.edit_report', compact('apply'));
    }

    public function updateReport(UpdateApplyReportRequest $request, Apply $apply)
    {
        $this->authorize('update', $apply);

        if ($apply->IsWithinHalfYear === false || $apply->s_recruit_status === 1 || $apply->s_recruit_status === 8) {
            return redirect()->route('index.seeker.job');
        }

        $data = [];
        $input = $request->input('data.apply');

        // dd($request->input('data.Apply.pushed'));

        $applyRepo = new ApplyRepository($apply);

        if ($request->input('data.Apply.pushed') == 'SaveAdoptStatus') {
            $data = [
                's_first_attendance' => Carbon::create(
                    $input['year'],
                    $input['month'],
                    $input['date']
                ),
                's_recruit_status' => 1,
                'congrats_application_status' => 1,
            ];
        } elseif ($request->input('data.Apply.pushed') == 'SaveTmpAdoptStatus') {
            $data = [
                's_nofirst_attendance' => $input['s_nofirst_attendance'],
                's_recruit_status' => 1,
            ];
        } elseif ($request->input('data.Apply.pushed') == 'SaveUnAdoptCancelStatus') {
            $data = [
                's_recruit_status' => 2,
            ];
        } elseif ($request->input('data.Apply.pushed') == 'SaveReportCancelStatus') {
            $data = [
                's_recruit_status' => 0,
            ];
        } elseif ($request->input('data.Apply.pushed') == 'SaveReportDeclineStatus') {
            $data = [
                's_recruit_status' => 8,
            ];
        }

        $applyRepo->update($data);

        session()->flash('flash_message_success', 'ご報告ありがとうございました！');
        return redirect()->route('index.seeker.job');
    }

    public function unAdoptJob($applyJobItemId)
    {

        $applyJobItemQuery = DB::table('apply_job_item')->where('id', $applyJobItemId);
        $applyJobItemQuery->update([
            's_status' => 2,
        ]);

        return redirect()->route('mypage.jobapp.manage')->with('flash_message_success', 'ご報告ありがとうございました！');
    }

    public function adoptCancelJob($applyJobItemId)
    {
        $applyJobItemQuery = DB::table('apply_job_item')->where('id', $applyJobItemId);
        $applyJobItemQuery->update([
            's_status' => 0,
        ]);

        return redirect()->route('mypage.jobapp.manage')->with('flash_message_success', '報告を取り消しました。');
    }

    public function jobDecline($applyJobItemId)
    {
        $applyJobItemQuery = DB::table('apply_job_item')->where('id', $applyJobItemId);
        $applyId = $applyJobItemQuery->first()->apply_id;

        $apply = $this->applyRepo->findApplyById($applyId);

        DB::beginTransaction();
        try {

            $applyJobItemQuery->delete();
            $apply->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }



        return redirect()->route('mypage.jobapp.manage')->with('flash_message_success', '応募を辞退しました');
    }
}
