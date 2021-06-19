<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function subcategories()
    {
        return $this->hasMany('App\Model\SubCategory','category_id');
    }
    public function shopcategories()
    {
        return $this->hasMany('App\Model\ShopCategory','category_id');
    }
    public function product()
    {
        return $this->hasMany('App\Model\Product','category_id');
    }
}
