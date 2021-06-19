<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopSubSubcategory extends Model
{
    protected $guarded = [];
    public function subsubcategory()
    {
        return $this->belongsTo('App\Model\SubSubcategory', 'subsubcategory_id');
    }
    public function subcategory()
    {
        return $this->belongsTo('App\Model\Subcategory', 'subcategory_id');
    }
    public function shop()
    {
        return $this->belongsTo('App\Model\Shop', 'shop_id');
    }
}
