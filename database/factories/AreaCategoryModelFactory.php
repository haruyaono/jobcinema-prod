<?php
use App\Job\Categories\AreaCategory;
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

$factory->define(AreaCategory::class, function (Faker $faker) {

    $name = $faker->unique()->randomElement([
        '昭和・鳥取・新富士',
        '星が浦・鶴野',
        '大楽毛',
        '阿寒・白糠',
        '釧路駅前',
        '釧路駅裏',
        '愛国',
        '釧路町',
        '芦野',
        '文苑・美原',
        '釧路春採・桜ヶ岡・興津',
        '緑ヶ岡・貝塚・武佐',
        '米町～鶴ヶ岱',
        '中標津・標茶・厚岸'
    ]);

    return [
        'name' => $name,
    ];
});

