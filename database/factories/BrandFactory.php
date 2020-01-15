<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Brand::class, function (Faker $faker) {
    return [
        'name' => strtoupper($faker->word),
        'code' => $faker->countryCode,
    ];
});
