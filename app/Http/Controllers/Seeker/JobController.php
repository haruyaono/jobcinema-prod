<?php

namespace App\Http\Controllers\Seeker;

use App\Models\Apply;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Mail\Seeker\ApplyReport;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Seeker\UpdateApplyReportRequest;

class JobController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = \Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $applies = $this->user->applies->filter(function ($apply) {
            return $apply->IsWithinHalfYear;
        })->whereNotIn('s_recruit_status', [8]);

        return view('seeker.job.index', compact('applies'));
    }

    public function showReport(Apply $apply)
    {
        $this->authorize('view', $apply);

        if ($apply->IsWithinHalfYear === false) {
            return redirect()->route('seeker.index.job');
        }

        return view('seeker.job.show_report', compact('apply'));
    }

    public function editReport(Apply $apply)
    {
        $this->authorize('view', $apply);

        $user =  $this->user;

        if ($apply->IsWithinHalfYear === false) {
            return redirect()->route('seeker.index.job');
        }

        return view('seeker.job.edit_report', compact('apply'));
    }

    public function updateReport(UpdateApplyReportRequest $request, Apply $apply)
    {
        $this->authorize('update', $apply);

        if ($apply->IsWithinHalfYear === false || $apply->s_recruit_status === 8) {
            return redirect()->route('seeker.index.job');
        }

        $data = [];
        $input = $request->input('data.apply');
        $status = $apply->s_recruit_status;

        switch (true) {
            case ($status === 0 || $status === 1):
                //初出社日が未定
                if ($request->input('data.Apply.pushed') == 'SaveTmpAdoptStatus') {
                    $data = [
                        's_nofirst_attendance' => $input['s_nofirst_attendance'],
                        's_recruit_status' => 1,
                    ];
                }
                // if ($status === 0 || ($status === 1 && $apply->s_nofirst_attendance != null)) {
                //初出社日
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
                } elseif ($request->input('data.Apply.pushed') == 'SaveReportDeclineStatus') {
                    $data = [
                        's_recruit_status' => 8,
                    ];
                    Mail::to($apply->jobitem->company->employer->email)->queue(new ApplyReport($apply));
                } elseif ($request->input('data.Apply.pushed') == 'SaveUnAdoptStatus') {
                    $data = [
                        's_recruit_status' => 2,
                    ];
                }
                // }
                break;
            case ($status === 2):
                if ($request->input('data.Apply.pushed') == 'SaveReportCancelStatus') {
                    $data = [
                        's_recruit_status' => 0,
                    ];
                }
                break;
        }

        $apply->update($data);

        session()->flash('flash_message_success', 'ご報告ありがとうございました！');
        return redirect()->route('seeker.index.job');
    }
}
