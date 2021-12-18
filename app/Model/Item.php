<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=
    [
        'name',
        'item_category_id',
        'user_id',
        'api_key_id',
        'location',
        'pos_item_id',
        'costing_price',
        'selling_price',
        'average_costing_price',
        'opening_stock',
        'current_stock',
        'delete_status'
    ];

    public function item_category()
    {
        return $this->belongsTo('App\Model\ItemCategory');
    }

    public function sale_items()
    {
        return $this->hasMany('App\Model\SaleItem');
    }

    public function purchase_items()
    {
        return $this->hasMany('App\Model\PurchaseItem');
    }
    public function nozzle()
    {
        return $this->belongsTo('App\Model\Nozzle');
    }
}
