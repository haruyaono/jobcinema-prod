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
use App\Job\Applies\Apply;
use App\Job\Users\User;

$factory->define(Apply::class, function (Faker\Generator $faker) {

    $user = factory(User::class)->create();

    return [
        'user_id' => $user->id,
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'postcode' => $faker->postcode,
        'prefecture' => $faker->country,
        'city' => $faker->city,
        'gender' => $faker->titleMale,
        'age' =>  $faker->numberBetween(18, 99),
        'phone1' => '080',
        'phone2' =>  '1122',
        'phone3' =>  '3344',
        'occupation' => $faker->jobTitle,
        'final_education' => $faker->sentence,
        'work_start_date' => $faker->sentence,
        'job_msg' => $faker->sentence,
        'job_q1' =>  $faker->paragraph,
        'job_q2' => $faker->paragraph,
        'job_q3' =>  $faker->paragraph,
    ];
});