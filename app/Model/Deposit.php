<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable=
    [
        'customer_id',
        'account_id',
        'purpose_id',
        'sale_id',
        'user_id',
        'api_key_id',
        'location',
        'pos_sale_id',
        'deposit_date',
        'note',
        'voucher_number',
        'money_receipt',
        'total_amount',
        'deposit_type',
        'delete_status'
    ];

    public function getTransactionAttribute()
    {
        return 'deposit';
    }

    public function transform()
    {
        return [
            'transaction_date' => $this->deposit_date,
            'transaction_voucher' => $this->voucher_number,
            'transaction_type' => $this->deposit_type,
            'transaction_purpose' => $this->purpose->name,
            'transaction_note' =>   $this->note,
            'transaction_total_amount' => $this->total_amount,
            'transaction_deposit' => ($this->transaction == 'deposit') ? $this->total_amount : '0.00',
            'transaction_withdraw' => ($this->transaction == 'withdraw') ? $this->total_amount : '0.00'
        ];
    }

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }

    public function account()
    {
        return $this->belongsTo('App\Model\Account');
    }

    public function purpose()
    {
        return $this->belongsTo('App\Model\Purpose');
    }

    public function sale()
    {
        return $this->belongsTo('App\Model\Sale');
    }
}
