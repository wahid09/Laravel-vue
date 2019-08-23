<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->PhoneNumber,
        'address' => $faker->address,
        'total' => $faker->randomFloat($nbMaxDecimals = 2, $min = 100.00, $max = 1000.00) // 48.8932,
    ];
});
