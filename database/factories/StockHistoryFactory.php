<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\StockHistory::class, function (Faker $faker) {
    return [
        'quantity' => $faker->numberBetween(-100, 100),
        'note' => $faker->sentence(4),
    ];
});
