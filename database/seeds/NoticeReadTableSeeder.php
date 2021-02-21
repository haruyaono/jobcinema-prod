<?php

use Illuminate\Database\Seeder;
use App\Models\NoticeRead;

class NoticeReadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NoticeRead::create([
            'notice_id' => 1,
            'company_id' => 1,
        ]);
        NoticeRead::create([
            'notice_id' => 1,
            'user_id' => 1,
        ]);
    }
}
