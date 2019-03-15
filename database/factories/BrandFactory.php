<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'code' => $faker->countryCode,
    ];
});
