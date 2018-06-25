<?php

use App\Core\Product\Models\Product;
use Faker\Generator as Faker;

$factory->define(App\Core\Review\Models\Review::class, function (Faker $faker) {
    return [
        'product_id' => function() {
            return Product::all()->random();
        },
        'customer' => $faker->name,
        'review' => $faker->paragraph,
        'star' => $faker->numberBetween(0, 5),
    ];
});
