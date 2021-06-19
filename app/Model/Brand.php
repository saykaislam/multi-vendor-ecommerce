<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->hasMany('App\Model\Product','brand_id');
    }
    public function shopbrand()
    {
        return $this->hasMany('App\Model\ShopBrand','brand_id');
    }
}
