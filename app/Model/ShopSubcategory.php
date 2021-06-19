<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopSubcategory extends Model
{
    protected $guarded = [];
    public function subcategory()
    {
        return $this->belongsTo('App\Model\Subcategory', 'subcategory_id');
    }
    public function shop()
    {
        return $this->belongsTo('App\Model\Shop', 'shop_id');
    }
}
