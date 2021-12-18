<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable=[
        'sale_date',
        'customer_id',
        'user_id',
        'api_key_id',
        'location',
        'pos_sale_id',
        'total_sale_quantity',
        'total_discount',
        'sub_total_amount',
        'total_amount',
        'delete_status',
        'hold_status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }

    public function sale_items()
    {
        return $this->hasMany('App\Model\SaleItem');
    }

    public function deposits()
    {
        return $this->hasMany('App\Model\Deposit');
    }
}
