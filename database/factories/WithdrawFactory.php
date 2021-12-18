<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Account;
use App\Model\Withdraw;
use App\Model\Party;
use App\Model\Purpose;
use Faker\Generator as Faker;

$factory->define(Withdraw::class, function (Faker $faker) {
    $startDate = date('Y-m-d H:i:s', strtotime('2020-07-19 20:08:56'));
    $endDate   = date('Y-m-d H:i:s', strtotime('2021-07-30 20:09:46'));
    return [
        'withdraw_date'  => $faker->dateTimeBetween($startDate, $endDate),
        'user_id'        => 1,
        'party_id'       => Party::all()->random()->id,
        'account_id'     => Account::whereNotIn('id', [1,2])->get()->random()->id,
        'purpose_id'     => Purpose::where('delete_status', '0')->where('purpose_type', 'expanse')->get()->random()->id,
        'voucher_number' => $faker->bothify('?###??##'),
        'total_amount'   => $faker->numerify('#####'),
        'note'           => $faker->text(15)
    ];
});
