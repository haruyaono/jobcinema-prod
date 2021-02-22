<?php

namespace App\Services;

use App\Models\Notice;

class NoticeService
{
    private $Notice;

    public function __construct(
        Notice $notice
    ) {
        $this->Notice = $notice;
    }

    public function getNoticeForCompany()
    {
        $notices = Notice::where("is_delivered", true)->where("target", "全体")->orWhere("target", "企業")->get();
        return $notices;
    }

    public function getNoticeForUser()
    {
        $notices = Notice::where("is_delivered", true)->where("target", "全体")->orWhere("target", "応募者")->get();
        return $notices;
    }
}