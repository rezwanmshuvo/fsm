<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable=
    [
        'api_key_id',
        'tank_id',
        'name',
        'model',
        'no_of_nozzle',
        'serial_no',
        'delete_status'
    ];

    public function tank()
    {
        return $this->belongsTo('App\Model\Tank');
    }
    public function nozzles()
    {
        return $this->hasMany('App\Model\Nozzle');
    }
}
