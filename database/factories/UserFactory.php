<?php
use App\Models\Admin;
use App\Models\User;
use App\Models\Employer;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

// $factory->define(App\Models\User::class, function (Faker $faker) {
//     return [
//         'last_name' => $faker->lastName,
//         'first_name' => $faker->firstName,
//         'email' => $faker->unique()->safeEmail,
//         'email_verified_at' => now(),
//         'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
//         'remember_token' => Str::random(10),
//     ];
// });

// $factory->define(App\Models\Admin::class, function (Faker $faker) {
//     return [
//         'name' => $faker->name,
//         'email' => $faker->unique()->safeEmail,
//         'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
//         'remember_token' => Str::random(10),
//     ];
// });

// $factory->define(App\Models\Employer::class, function (Faker $faker) {
//     return [
//         'last_name' => $faker->lastName,
//         'first_name' => $faker->firstName,
//         'last_name_katakana' => $faker->lastKanaName,
//         'first_name_katakana' => $faker->firstKanaName,
//         'status' => 1,
//         'email' => $faker->unique()->safeEmail,
//         'email_verified_at' => now(),
//         'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
//         'remember_token' => Str::random(10),
//     ];
// });

// $factory->define(App\Models\Company::class, function (Faker $faker) {
//     return [
//         'employer_id' => $employerId = App\Models\Employer::all()->random()->id,
//         'cname' => $name = $faker->company,
//         'cname_katakana' => 'カブシキカイシャ　ジョブシネマ',
//         'slug' => str_slug($employerId),
//         'website' => $faker->domainName,
//         'postcode' => $faker->postcode,
//         'prefecture' => $faker->prefecture,
//         'address' => $faker->streetAddress,
//         'phone1' => '080',
//         'phone2' => '1111',
//         'phone3' => '2222',
//         'industry' => $faker->jobTitle,
//         'logo' => '',
//         'description' => $faker->sentence,
//         'foundation' =>  $faker->date,
//         'ceo' => $faker->name,
//         'capital' => $faker->numberBetween($min=1000, $max=100000000),
//         'employee_number' => $faker->numberBetween($min=1, $max=100),
//     ];
// });

// $factory->define(App\Models\JobItem::class, function (Faker $faker) {
//     return [
//         'employer_id' => App\Models\Employer::all()->random()->id,
//         'company_id' => $companyId = App\Models\Company::all()->random()->id,
//         'job_title' => $jobname=$faker->sentence,
//         'slug' => $companyId,
//         'status' => rand(0,1),
//         'job_img' => '',
//         'job_img2' => '',
//         'job_img3' => '',
//         'job_mov' => '',
//         'job_mov2' => '',
//         'job_mov3' => '',
//         'job_type' => $faker->jobTitle,
//         'job_hourly_salary' => '８５０円以上',
//         'job_office' => $faker->company,
//         'job_office_address' => $faker->address,
//         'job_desc' => $faker->paragraph,
//         'job_intro' => $faker->sentence,
//         'salary_increase' => $jobname=$faker->sentence,
//         'job_time' => '8:00~16:00',
//         'job_target' => $faker->sentence,
//         'job_treatment' => $faker->sentence,
//         'pub_start' => $faker->date,
//         'pub_end' => $faker->date,
//         'remarks' => $faker->sentence,
//         'status_cat_id' => rand(1,4),
//         'type_cat_id' => rand(1,16),
//         'area_cat_id' => rand(1,14),
//         'hourly_salary_cat_id' => rand(1,11),
//         'date_cat_id' => rand(1,6),
//     ];
// });
