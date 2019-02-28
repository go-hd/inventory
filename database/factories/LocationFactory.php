<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'location_code' => $faker->countryCode,
        'location_number' => $faker->numberBetween(0, 999)
    ];
});
