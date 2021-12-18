<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable=
    [
        'party_id',
        'account_id',
        'purpose_id',
        'purchase_id',
        'user_id',
        'api_key_id',
        'location',
        'pos_receiving_id',
        'pos_expense_id',
        'withdraw_date',
        'note',
        'voucher_number',
        'money_receipt',
        'total_amount',
        'withdraw_type',
        'delete_status'
    ];

    public function getTransactionAttribute()
    {
        return 'withdraw';
    }

    public function transform()
    {
        return [
            'transaction_date' => $this->withdraw_date,
            'transaction_voucher' => $this->voucher_number,
            'transaction_type' => $this->withdraw_type,
            'transaction_purpose' => $this->purpose->name,
            'transaction_note' =>   $this->note,
            'transaction_total_amount' => $this->total_amount,
            'transaction_deposit' => ($this->transaction == 'deposit') ? $this->total_amount : '0.00',
            'transaction_withdraw' => ($this->transaction == 'withdraw') ? $this->total_amount : '0.00'
        ];
    }

    public function party()
    {
        return $this->belongsTo('App\Model\Party');
    }

    public function account()
    {
        return $this->belongsTo('App\Model\Account');
    }

    public function purpose()
    {
        return $this->belongsTo('App\Model\Purpose');
    }

    public function purchase()
    {
        return $this->belongsTo('App\Model\Purchase');
    }
}
