<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable=
    [
        'user_id',
        'api_key_id',
        'location',
        'pos_supplier_id',
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

    public function purchases()
    {
        return $this->hasMany('App\Model\Purchase');
    }

    public function withdraws()
    {
        return $this->hasMany('App\Model\Withdraw');
    }
}
