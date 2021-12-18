<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $fillable=
    [
        'name',
        'parent_id',
        'user_id',
        'api_key_id',
        'pos_category_id',
        'delete_status'
    ];

    protected $appends = [
        'parent'
    ];

    public function parent()
    {
        return $this->belongsTo('App\ItemCategory', 'parent_id', 'id');
    }

    /**
     * Get the Child Category For The Category.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\ItemCategory','parent_id','id') ;
    }

    public function getParentAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while(!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    public function items()
    {
        return $this->hasMany('App\Model\Item');
    }
}
