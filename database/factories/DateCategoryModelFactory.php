<?php
use App\Job\Categories\DateCategory;
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

$factory->define(DateCategory::class, function (Faker $faker) {

    $name = $faker->unique()->randomElement([
        '週１日〜',
        '週２日〜',
        '週３日〜',
        '週４日〜',
        '週５日〜',
        '週６日〜',
    ]);

    return [
        'name' => $name,
    ];
});

