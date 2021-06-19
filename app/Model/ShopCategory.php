<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id');
    }
    public function shop()
    {
        return $this->belongsTo('App\Model\Shop', 'shop_id');
    }

}
