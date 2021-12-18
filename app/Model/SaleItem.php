<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable=[
        'sale_id',
        'item_id',
        'user_id',
        'api_key_id',
        'location',
        'pos_sale_item_id',
        'sale_quantity',
        'unit_price',
        'discount',
        'sub_total',
        'total'
    ];
    public function sale()
    {
        return $this->belongsTo('App\Model\Sale');
    }

    public function item()
    {
        return $this->belongsTo('App\Model\Item');
    }
}
