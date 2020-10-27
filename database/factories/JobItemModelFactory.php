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
use App\Job\Companies\Company;
use Illuminate\Http\UploadedFile;

$factory->define(JobItem::class, function (Faker\Generator $faker) {

    $employer = factory(Employer::class)->create();
    $company = factory(Company::class)->create([
        'employer_id' => $employer->id,
    ]);
    $file = UploadedFile::fake()->image('jobitem.png', 800, 500);

    return [
        'company_id' => $company->id,
        'job_title' => $faker->sentence,
        'status' => $faker->randomElement([0, 1, 2, 3, 4, 8, 9, 99]),
        'job_img_1' => $file->store('test/jobitems', ['disk' => 'public']),
        'job_img_2' =>  $file->store('test/jobitems', ['disk' => 'public']),
        'job_img_3' =>  '',
        'job_mov_1' =>  $file->store('test/jobitems', ['disk' => 'public']),
        'job_mov_2' =>  $file->store('test/jobitems', ['disk' => 'public']),
        'job_mov_3' => '',
        'job_type' => $faker->jobTitle,
        'job_salary' => '８５０円以上',
        'job_office' => $company->cname,
        'job_office_address' => $company->prefecture . '' . $company->address,
        'job_desc' => $faker->paragraph,
        'job_intro' => $faker->sentence,
        'salary_increase' => $faker->sentence,
        'job_time' => '8:00~16:00',
        'job_target' => $faker->sentence,
        'job_treatment' => $faker->sentence,
        'pub_start_flag' => $faker->randomElement([0, 1]),
        'pub_start_date' => $faker->date,
        'pub_end_flag' => $faker->randomElement([0, 1]),
        'pub_emd_date' => $faker->date,
        'remarks' => $faker->sentence,
    ];
});
