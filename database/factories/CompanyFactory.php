<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'company_code' => $faker->countryCode,
    ];
});
