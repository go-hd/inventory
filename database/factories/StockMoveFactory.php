<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\StockMove::class, function (Faker $faker) {
    return [
        'quantity' => $faker->numberBetween(1, 100),
    ];
});
