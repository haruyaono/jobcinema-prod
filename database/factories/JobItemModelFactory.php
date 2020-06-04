<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Job\JobItems\JobItem;
use App\Job\Employers\Employer;
use App\Models\Company;
use Illuminate\Http\UploadedFile;

$factory->define(JobItem::class, function (Faker\Generator $faker) {

    $employer = factory(Employer::class)->create();
    $company = factory(Company::class)->create([
        'employer_id' => $employer->id,
    ]);
    $jobitem = $faker->unique()->sentence;
    $file = UploadedFile::fake()->image('jobitem.png', 800, 500);

    return [
        'employer_id' => $employer->id,
        'company_id' => $company->id,
        'job_title' => $jobitem,
        'oiwaikin' => '2000円',
        'slug' => str_slug($jobitem),
        'status' => 2,
        'job_img' => $file->store('test/jobitems', ['disk' => 'public']),
        'job_img2' =>  $file->store('test/jobitems', ['disk' => 'public']),
        'job_img3' => '',
        'job_img2' =>  $file->store('test/jobitems', ['disk' => 'public']),
        'job_mov' =>  $file->store('test/jobitems', ['disk' => 'public']),
        'job_mov2' =>  $file->store('test/jobitems', ['disk' => 'public']),
        'job_mov3' => '',
        'job_type' => $faker->jobTitle,
        'job_hourly_salary' => '８５０円以上',
        'job_office' => $company->cname,
        'job_office_address' => $company->prefecture .''. $company->address,
        'job_desc' => $faker->paragraph,
        'job_intro' => $faker->sentence,
        'salary_increase' => $jobname=$faker->sentence,
        'job_time' => '8:00~16:00',
        'job_target' => $faker->sentence,
        'job_treatment' => $faker->sentence,
        'pub_start' => '最短で掲載',
        'pub_end' => '無期限で掲載',
        'remarks' => $faker->sentence,
        'status_cat_id' => rand(1,4),
        'type_cat_id' => rand(1,16),
        'area_cat_id' => rand(1,14),
        'hourly_salary_cat_id' => rand(1,11),
        'date_cat_id' => rand(1,6),
    ];
});