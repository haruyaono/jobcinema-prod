<?php

use App\Models\Profile;
use App\Models\User;
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

$factory->define(Profile::class, function (Faker $faker) {

    static $password;
    $user = factory(User::class)->create();

    return [
        'user_id' => $user->id,
        'postcode' => $faker->postcode,
        'prefecture' => $faker->prefecture,
        'city' => $faker->city,
        'gender' => $faker->randomElement(['男性', '女性']),
        'age' => $faker->numberBetween(18, 99),
        'phone1' => '080',
        'phone2' => '1111',
        'phone3' => '2222',
        'occupation' => $faker->jobTitle,
        'final_education' => $faker->sentence,
        'work_start_date' => $faker->sentence,
    ];
});

// $factory->define(App\Models\Admin::class, function (Faker $faker) {
//     return [
//         'name' => $faker->name,
//         'email' => $faker->unique()->safeEmail,
//         'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
//         'remember_token' => Str::random(10),
//     ];
// });
