<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Services\NoticeReadService;
use App\Services\NoticeService;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $uid = Auth::id();
        $nrs = $this->NoticeReadService;
        $notices = $this->NoticeService->getNoticeForUser();
        return view('seeker.notice.index', compact('notices', 'uid', 'nrs'));
    }

    public function show(Notice $notice)
    {
        $uid = Auth::id();
        if (!$this->NoticeReadService->isReadUser($uid, $notice->id)) {
            $this->NoticeReadService->readUser($uid, $notice->id);
        }
        return view('seeker.notice.show', compact('notice'));
    }
}
