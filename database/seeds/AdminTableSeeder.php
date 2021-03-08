<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'jobcinema_adminuser_fv6Ei',
            'email' => 'masaya.takeda.wm@gmail.com',
            'password' => bcrypt('RuMBkul8wte'),
            'remember_token' => null,
        ]);
    }
}
