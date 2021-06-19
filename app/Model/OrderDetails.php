<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'order_id');
    }
    public function productStock()
    {
        return $this->belongsTo('App\Model\ProductStock', 'variation_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }
}
