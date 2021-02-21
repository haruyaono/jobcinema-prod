<?php

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'user_id' => 1,
            'postcode' => '100-8111',
            'prefecture' => '東京都',
            'city' => '千代田区',
            'gender' => '男性',
            'age' => '20',
            'phone1' => '080',
            'phone2' => '1234',
            'phone3' => '5678',
            'occupation' => '社会人',
            'final_education' => '高校',
            'work_start_date' => '面接時に相談'
        ]);
    }
}
