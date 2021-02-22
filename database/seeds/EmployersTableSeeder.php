<?php

use Illuminate\Database\Seeder;
use App\Models\Employer;

class EmployersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employer::create([
            'email' => 'tarou.yamada.c@example.com',
            'last_name' => '山田',
            'first_name' => '太郎',
            'last_name_katakana' => 'ヤマダ',
            'first_name_katakana' => 'タロウ',
            'phone1' => '080',
            'phone2' => '1234',
            'phone3' => '5678',
            'status' => '1',
            'email_verified_at' => '2020-01-01 00:00:00',
            'email_verified' => '2',
            'email_verify_token' => 'abcdefghijklmnopqestuvwxyz0123456789',
            'password' => bcrypt("helloWorld"),
        ]);
    }
}