<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Nozzle extends Model
{
    protected $fillable=
    [
        'api_key_id',
        'machine_id',
        'item_id',
        'name',
        'start_reading',
        'current_reading',
        'delete_status'
    ];

    public function machine()
    {
        return $this->belongsTo('App\Model\Machine');
    }

    public function item()
    {
        return $this->belongsTo('App\Model\Item');
    }
}
