<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Services\NoticeService;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    private $NoticeService;

    public function __construct(
        NoticeService $noticeService
    ) {
        $this->NoticeService = $noticeService;
    }

    public function index()
    {
        $notices = $this->NoticeService->getNoticeForCompany();
        return view('companies.notice.index', compact('notices'));
    }

    public function show(Notice $notice)
    {
        return view('companies.notice.show', compact('notice'));
    }
}
