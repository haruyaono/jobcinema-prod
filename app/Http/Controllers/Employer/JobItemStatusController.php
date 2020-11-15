<?php

namespace App\Http\Controllers\Employer;

use Illuminate\Http\Request;
use App\Models\JobItem;
use App\Http\Controllers\Controller;

class JobItemStatusController extends Controller
{
    private $JobItem;

    public function __construct(JobItem $JobItem)
    {
        $this->JobItem = $JobItem;
    }

    public function editStatusApplyCancel(JobItem $jobitem)
    {
        return view('companies.job_sheet.status.edit_apply_cancel', compact('jobitem'));
    }

    public function editStatusStopPosting(JobItem $jobitem)
    {
        return view('companies.job_sheet.status.edit_postend', compact('jobitem'));
    }

    public function updateStatus(Request $request, JobItem $jobitem)
    {
        $request = $request->input('data.JobSheet');

        if ((int) $request['id'] !== $jobitem->id) {
            return redirect()->back();
        }

        $flag = '';
        $data = [];
        $message = "正常に変更されました!";

        switch ($request['pushed']) {
            case "updateApplyCancel":
                if ($jobitem->status !== 1) {
                    break;
                }
                $data = ['status' => 0];
                $message = "求人票【" . $jobitem->id . "】の申請を取り消しました!";
                break;
            case "updatePostend":
                if ($jobitem->status !== 2) {
                    break;
                }
                $data = ['status' => 3];
                $message = "求人票【" . $jobitem->id . "】の掲載を終了しました!";
                break;
        }

        if (!empty($data)) {
            $jobitem->update($data);
        }

        return view('companies.job_sheet.status.status_update_complete', compact('message', 'flag'));
    }

    public function editStatusDelete(Request $request, JobItem $jobitem)
    {
        $this->authorize('delete', $jobitem);

        $message = "求人票【" . $jobitem->id . "】を削除しました！";

        $jobitem->update(['status' => 9]);

        $flag = 9;

        return view('companies.job_sheet.status.status_update_complete', compact('message', 'flag'));
    }
}
