<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Job\Users\User;
use App\Models\Employer;
use App\Job\JobItems\JobItem;
use App\Models\Company;
use App\Job\Categories\StatusCategory;
use App\Job\Categories\TypeCategory;
use App\Job\Categories\HourlySalaryCategory;
use App\Job\Categories\AreaCategory;
use App\Job\Categories\DateCategory;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        // DB::table('admins')->truncate();
        DB::table('employers')->truncate();
        DB::table('companies')->truncate();
        DB::table('job_items')->truncate();
        DB::table('status_categories')->truncate();
        DB::table('type_categories')->truncate();
        DB::table('area_categories')->truncate();
        DB::table('hourly_salary_categories')->truncate();
        DB::table('date_categories')->truncate();
        DB::table('profiles')->truncate();
        DB::table('job_item_user')->truncate();
        DB::table('favourites')->truncate();
        

        factory(User::class, 20)->create();
        // factory('App\Models\Admin', 1)->create();
        factory(Employer::class)->create();
        factory(Company::class)->create();
        factory(JobItem::class)->create();
        factory(StatusCategory::class, 4)->create();
        factory(TypeCategory::class, 16)->create();
        factory(AreaCategory::class, 14)->create();
        factory(HourlySalaryCategory::class, 11)->create();
        factory(DateCategory::class, 6)->create();
    }
}
