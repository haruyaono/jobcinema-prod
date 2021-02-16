<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'employer_id' => '1',
            'cname' => '株式会社Example',
            'cname_katakana' => 'カブシキガイシャイクザンプル',
            'website' => 'https://www.example.com',
            'logo' => 'NULL',
            'postcode' => '100-8111',
            'prefecture' => '東京都',
            'address' => '千代田区1-1',
            'phone1' => '0120',
            'phone2' => '123',
            'phone3' => '456',
            'industry' => 'IT・通信',
            'description' => '技術研究',
            'foundation' => '2021年1月',
            'ceo' => '山田・マイケル・太郎',
            'capital' => '1億',
            'employee_number' => '11~50人',
        ]);
    }
}