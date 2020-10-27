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
use App\Job\JobItems\JobItem;

$factory->define(Apply::class, function (Faker\Generator $faker) {
    static $password;
    $user = factory(User::class)->create();
    $jobitem = factory(JobItem::class)->create();

    return [
        'user_id' => $user->id,
        'job_item_id' => $jobitem->id,
        's_recruit_status' => $faker->randomElement([0, 1, 2, 8]),
        'e_recruit_status' => $faker->randomElement([0, 1, 2, 8]),
        'congrats_amount' => $faker->randomNumber,
        'congrats_status' => $faker->randomElement([0, 1, 2]),
        's_first_attendance' => $faker->date,
        's_nofirst_attendance' => $faker->sentence,
        'e_first_attendance' => $faker->date,
        'e_nofirst_attendance' => $faker->sentence,
        'recruitment_fee' =>  $faker->randomNumber,
        'recruitment_status' => $faker->randomElement([0, 1, 2])
    ];
});
