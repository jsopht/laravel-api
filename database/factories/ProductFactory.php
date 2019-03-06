<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'lm' => $faker->numberBetween($min = 1000, $max = 9000),
        'category_id' => function () {
            return factory(App\Category::class)->create()->id;
        },
        'name' => $faker->name,
        'free_shipping' => $faker->boolean,
        'description' => $faker->realText($maxNbChars = 200),
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 999999),
    ];
});
