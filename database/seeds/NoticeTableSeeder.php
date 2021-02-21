<?php

use Illuminate\Database\Seeder;
use App\Models\Notice;

class NoticeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notice::create([
            'subject' => '全体向けお知らせ',
            'content' => '全体向けのお知らせです。
内容をご確認ください。',
            'target' => '全体',
            'is_delivered' => false,
            'delivered_at' => date("Y-m-d H:i:s", 1614524400),
        ]);
        Notice::create([
            'subject' => '応募者向けお知らせ',
            'content' => '応募者向けのお知らせです。
内容をご確認ください。',
            'target' => '応募者',
            'is_delivered' => false,
            'delivered_at' => date("Y-m-d H:i:s", 1614524400),
        ]);
        Notice::create([
            'subject' => '企業向けお知らせ',
            'content' => '企業向けのお知らせです。
内容をご確認ください。',
            'target' => '企業',
            'is_delivered' => false,
            'delivered_at' => date("Y-m-d H:i:s", 1614524400),
        ]);
    }
}
