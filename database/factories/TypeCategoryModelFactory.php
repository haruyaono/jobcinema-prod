<?php
use App\Job\Categories\TypeCategory;
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

$factory->define(TypeCategory::class, function (Faker $faker) {

    $name = $faker->unique()->randomElement([
        '事務・オフィス',
        '飲食・フード',
        '販売・接客・サービス',
        'アパレル・ファッション',
        '美容・エステ',
        'エンタメ・アミューズメント',
        '営業',
        'Web・クリエイティブ',
        'IT・エンジニア',
        '教育',
        '医療・介護・保育',
        '工場・製造',
        '倉庫・軽作業',
        '物流・配送',
        '建築・土木',
        'その他'
    ]);

    return [
        'name' => $name,
    ];
});

