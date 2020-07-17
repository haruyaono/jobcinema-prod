<?php
use App\Job\Categories\StatusCategory;
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

$factory->define(StatusCategory::class, function (Faker $faker) {

    $name = $faker->unique()->randomElement([
        '正社員',
        'パート・アルバイト',
        '契約社員',
        '業務委託・完全歩合制'
    ]);

    return [
        'name' => $name,
    ];
});

