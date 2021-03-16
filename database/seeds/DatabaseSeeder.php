<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use App\Models\User;
use App\Models\Profile;
// use App\Models\Employer;
use App\Models\JobItem;
// use App\Models\Company;
// use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('achievement_rewards')->truncate();
        DB::table('congrats_monies')->truncate();
        DB::table('categories')->truncate();
        DB::table('employers')->truncate();
        DB::table('companies')->truncate();
        DB::table('users')->truncate();
        DB::table('profiles')->truncate();
        DB::table('admins')->truncate();
        DB::table('job_items')->truncate();
        DB::table('profiles')->truncate();
        DB::table('favourites')->truncate();

        $this->call(CategoryTableSeeder::class);
        $this->call(AchievementRewardTableSeeder::class);
        $this->call(CongratsMoneyTableSeeder::class);
        $this->call(AdminTableSeeder::class);

        $this->call(AdItemTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(EmployersTableSeeder::class);
        $this->call(JobItemCategoryTableSeeder::class);
        $this->call(JobItemTableSeeder::class);
        $this->call(NoticeReadTableSeeder::class);
        $this->call(NoticeTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);

        // factory(Profile::class, 20)->create();
        // factory(JobItem::class, 20)->create();

        Schema::enableForeignKeyConstraints();
    }
}
