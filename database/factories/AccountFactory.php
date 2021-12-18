<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'bank_name'         => $faker->name,
        'account_name'      => $faker->name,
        'account_number'    => $faker->bankAccountNumber,
        'bank_branch'       => $faker->city,
        'opening_balance'   => $faker->numberBetween($min = 0, $max = 1000000)
    ];
});
