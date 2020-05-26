<?php
use App\Job\Categories\HourlySalaryCategory;
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

$factory->define(HourlySalaryCategory::class, function (Faker $faker) {

    $name = $faker->unique()->randomElement([
        '800円以上',
        '850円以上',
        '900円以上',
        '950円以上',
        '1000円以上',
        '1050円以上',
        '1100円以上',
        '1200円以上',
        '1300円以上',
        '1400円以上',
        '1500円以上'
    ]);

    return [
        'name' => $name,
    ];
});

