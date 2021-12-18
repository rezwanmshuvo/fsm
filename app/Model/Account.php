<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable=
    [
        'user_id',
        'api_key_id',
        'bank_name',
        'account_name',
        'account_number',
        'bank_branch',
        'opening_balance',
        'delete_status'
    ];

    public function deposits()
    {
        return $this->hasMany('App\Model\Deposit');
    }

    public function withdraws()
    {
        return $this->hasMany('App\Model\Withdraw');
    }
}
