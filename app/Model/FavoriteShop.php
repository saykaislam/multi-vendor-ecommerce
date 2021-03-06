<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FavoriteShop extends Model
{
    public function shop()
    {
        return $this->belongsTo('App\Model\Shop','shop_id');
    }
}
