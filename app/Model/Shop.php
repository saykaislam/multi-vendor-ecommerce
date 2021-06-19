<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded = [];

    public function shopCategories()
    {
        return $this->hasMany('App\Model\ShopCategory','shop_id');
    }
    public function seller()
    {
        return $this->belongsTo('App\Model\Seller','seller_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
