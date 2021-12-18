<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Account;
use App\Model\Customer;
use App\Model\Deposit;
use App\Model\Purpose;
use Faker\Generator as Faker;

$factory->define(Deposit::class, function (Faker $faker) {
    $startDate = date('Y-m-d H:i:s', strtotime('2021-07-31 00:00:00'));
    $endDate   = date('Y-m-d H:i:s', strtotime('2021-07-31 23:59:59'));
    return [
        'deposit_date'   => $faker->dateTimeBetween($startDate, $endDate),
        'user_id'        => 1,
        'customer_id'    => Customer::all()->random()->id,
        'account_id'     => Account::whereNotIn('id', [1,2])->get()->random()->id,
        'purpose_id'     => Purpose::where('delete_status', '0')->where('purpose_type', 'income')->get()->random()->id,
        'voucher_number' => $faker->bothify('?###??##'),
        'total_amount'   => $faker->numerify('######'),
        'note'           => $faker->text(15)
    ];
});
