<?php

use App\Job\Employers\Employer;
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

$factory->define(Employer::class, function (Faker $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'last_name_katakana' => $faker->lastKanaName,
        'first_name_katakana' => $faker->firstKanaName,
        'status' => $faker->randomElement([0, 1, 2, 8, 9]),
        'email_verified_at' => now(),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
    ];
});
