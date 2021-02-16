<?php

use Illuminate\Database\Seeder;
use App\Models\JobItem;

class JobItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobItem::create([
            'company_id' => '1',
            'status' => '2',
            'job_title' => 'テスト求人です！',
            'job_img_1' => 'b7f8cc7890d44b95d5637dfa18ce55ce4cad6ea5.jpg',
            'job_img_2' => NULL,
            'job_img_3' => NULL,
            'job_mov_1' => NULL,
            'job_mov_2' => NULL,
            'job_mov_3' => NULL,
            'job_type' => '営業',
            'job_salary' => '月給25万',
            'job_office' => '北海道',
            'job_office_address' => '釧路市--',
            'job_desc' => '広告の提案営業をお願いします！',
            'job_intro' => 'イエーイ！',
            'salary_increase' => '昇給あり！',
            'job_time' => 'フレックスタイム',
            'job_target' => '新卒・第二新卒、営業経験のある中途',
            'job_treatment' => '社保完備！',
            'pub_start_flag' => '0',
            'pub_start_date' => NULL,
            'pub_end_flag' => '0',
            'pub_end_date' => NULL,
            'remarks' => NULL,
            'job_q1' => '営業経験はありますか？',
            'job_q2' => NULL,
            'job_q3' => NULL,
        ]);
    }
}