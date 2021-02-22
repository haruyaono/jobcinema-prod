<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Services\NoticeService;
use App\Services\NoticeReadService;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    private $NoticeService;
    private $NoticeReadService;

    public function __construct(
        NoticeService $noticeService,
        NoticeReadService $noticeReadService
    ) {
        $this->NoticeService = $noticeService;
        $this->NoticeReadService = $noticeReadService;
    }

    public function index()
    {
        $user = Auth::user();
        $cid = $user->company->id;
        $nrs = $this->NoticeReadService;
        $notices = $this->NoticeService->getNoticeForCompany();
        return view('companies.notice.index', compact('notices', 'cid', 'nrs'));
    }

    public function show(Notice $notice)
    {
        $user = Auth::user();
        $cid = $user->company->id;
        if (!$this->NoticeReadService->isReadCompany($cid, $notice->id)) {
            $this->NoticeReadService->readCompany($cid, $notice->id);
        }
        return view('companies.notice.show', compact('notice'));
    }
}
