<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopBrand extends Model
{
    protected $guarded = [];
    public function brand()
    {
        return $this->belongsTo('App\Model\Brand', 'brand_id');
    }
    public function shop()
    {
        return $this->belongsTo('App\Model\Shop', 'shop_id');
    }
}
