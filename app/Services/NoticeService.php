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

    public function getNoticeForCompany() {}

    public function getNoticeForUser() {}

    public function getNoticeForAll() {}
}