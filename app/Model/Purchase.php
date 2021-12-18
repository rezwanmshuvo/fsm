<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable=
    [
        'purchase_date',
        'party_id',
        'user_id',
        'api_key_id',
        'location',
        'pos_receiving_id',
        'total_purchase_quantity',
        'total_discount',
        'sub_total_amount',
        'total_amount',
        'delete_status'
    ];

    public function party()
    {
        return $this->belongsTo('App\Model\Party');
    }

    public function purchase_items()
    {
        return $this->hasMany('App\Model\PurchaseItem');
    }

    public function withdraws()
    {
        return $this->hasMany('App\Model\Withdraw');
    }
}
