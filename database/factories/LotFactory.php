<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Lot::class, function (Faker $faker) {
    return [
        'lot_number' => $faker->unixTime,
        'name' => $faker->word,
        'jan_code' => $faker->unixTime,
        'expiration_date' => $faker->date('Y-m-d'),
        'ordered_at' => $faker->dateTime,
    ];
});
