<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    protected $fillable=
    [
        'purpose_id',
        'user_id',
        'api_key_id',
        'pos_purpose_id',
        'name',
        'purpose_type',
        'delete_status'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Model\Purpose', 'purpose_id', 'id');
    }

    /**
     * Get the Child Category For The Category.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\Model\Purpose','purpose_id','id') ;
    }

    public function deposits()
    {
        return $this->hasMany('App\Model\Deposit');
    }

    public function withdraws()
    {
        return $this->hasMany('App\Model\Withdraw');
    }
}
