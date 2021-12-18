<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = [
        'name',
        'pos_url',
        'system_key',
        'pos_key'
    ];
}
