<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Palette::class, function (Faker $faker) {
    return [
        'type' => $faker->word,
    ];
});
