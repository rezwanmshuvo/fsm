<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable=
    [
        'api_key_id',
        'name',
        'start_time',
        'end_time',
        'delete_status'
    ];
}
