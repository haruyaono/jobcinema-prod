<?php

use App\Models\Company;
use App\Models\Employer;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

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

$factory->define(Company::class, function (Faker $faker) {

    $employer = factory(Employer::class)->create();
    $file = UploadedFile::fake()->image('c_logo.png', 800, 600);

    return [
        'employer_id' => $employer->id,
        'cname' => $faker->company,
        'cname_katakana' => 'カブシキカイシャ〇〇',
        'website' => $faker->domainName,
        'postcode' => $faker->postcode,
        'prefecture' => $faker->prefecture,
        'address' => $faker->streetAddress,
        'phone1' => '080',
        'phone2' => '1111',
        'phone3' => '2222',
        'industry' => $faker->jobTitle,
        'logo' => $file->store('test/companies', ['disk' => 'public']),
        'description' => $faker->sentence,
        'foundation' =>  $faker->date,
        'ceo' => $faker->name,
        'capital' => $faker->numberBetween($min = 1000, $max = 100000000),
        'employee_number' => $faker->numberBetween($min = 1, $max = 100),
    ];
});
