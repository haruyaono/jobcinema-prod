<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'last_name' => 'ヤマダ',
            'first_name' => 'タロウ',
            'email' => 'tarou.yamada.u@example.com',
            'email_verified_at' => date("Y-m-d H:i:s"),
            'password' => Hash::make("helloWorld"),
        ]);
    }
}
