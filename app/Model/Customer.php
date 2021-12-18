<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable=
    [
        'user_id',
        'api_key_id',
        'location',
        'pos_customer_id',
        'name',
        'phone',
        'email',
        'image',
        'address',
        'bank_name',
        'account_name',
        'account_number',
        'bank_branch',
        'current_balance',
        'delete_status'
    ];

    public function sales()
    {
        return $this->hasMany('App\Model\Sale');
    }

    public function deposits()
    {
        return $this->hasMany('App\Model\Deposit');
    }
}
