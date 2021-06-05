<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\LocationType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'note' => $faker->sentence(4),
    ];
});