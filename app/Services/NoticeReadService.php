<?php


namespace App\Services;

use App\Models\Notice;
use App\Models\NoticeRead;

class NoticeReadService
{
    public function __construct() {}

    public function unreadCount(int $cid): int {

    }

    public function isReadCompany(int $cid, int $nid): bool {
        $count = NoticeRead::where("company_id", $cid)->where("notice_id", $nid)->count();
        return $count > 0;
    }

    public function readCompany(int $cid, int $nid) {
        Notice::create([
            'notice_id' => $nid,
            'company_id' => $cid,
        ]);
    }

    public function isReadUser(int $uid, int $nid): bool {
        $count = NoticeRead::where("user_id", $uid)->where("notice_id", $nid)->count();
        return $count > 0;
    }

    public function readUser(int $uid, int $nid) {
        Notice::create([
            'notice_id' => $nid,
            'user_id' => $uid,
        ]);
    }
}