<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable=
    [
        'purchase_id',
        'item_id',
        'user_id',
        'api_key_id',
        'location',
        'pos_receiving_item_id',
        'purchase_quantity',
        'unit_price',
        'discount',
        'sub_total',
        'total'
    ];

    public function purchase()
    {
        return $this->belongsTo('App\Model\Purchase');
    }

    public function item()
    {
        return $this->belongsTo('App\Model\Item');
    }
}
