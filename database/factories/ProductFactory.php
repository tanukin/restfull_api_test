<?php

use Faker\Generator as Faker;

$factory->define(App\Core\Product\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'detail' => $faker->paragraph,
        'price' => $faker->numberBetween(100, 1000),
        'stock' => $faker->randomDigit,
        'discount' => $faker->numberBetween(2, 30),
        'user_id' => function(){
            return App\User::all()->random();
        },
    ];
});
