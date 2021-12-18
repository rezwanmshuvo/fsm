<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $fillable=
    [
        'api_key_id',
        'name',
        'capacity',
        'dip_min',
        'dip_max',
        'dip_in_mm',
        'delete_status'
    ];

    public function machines()
    {
        return $this->hasMany('App\Model\Machine');
    }
}
