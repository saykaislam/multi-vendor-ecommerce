<?php

namespace App\Model;

use App\Model\Product;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    public function product(){
        return $this->belongsTo('App\Model\Product','product_id');
    }
    public function orderDetails(){
        return $this->hasMany('App\Model\OrderDetails','variation_id');
    }
}
