<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Job\Users\User;
use App\Job\Profiles\Profile;
use App\Job\Employers\Employer;
use App\Job\JobItems\JobItem;
use App\Job\Companies\Company;
use App\Job\Categories\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('achievement_rewards')->truncate();
        // DB::table('congrats_monies')->truncate();
        // DB::table('categories')->truncate();
        $this->call(CategoryTableSeeder::class);
        $this->call(AchievementRewardTableSeeder::class);
        $this->call(CongratsMoneyTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        // DB::table('users')->truncate();
        // DB::table('admins')->truncate();
        // DB::table('employers')->truncate();
        // DB::table('companies')->truncate();
        // DB::table('job_items')->truncate();
        // DB::table('profiles')->truncate();
        // DB::table('favourites')->truncate();

        // factory(User::class, 20)->create();
        // factory(Profile::class, 20)->create();
        // factory('App\Models\Admin', 1)->create();
        // factory(Employer::class)->create();
        // factory(Company::class)->create();
        // factory(JobItem::class)->create();
    }
}
