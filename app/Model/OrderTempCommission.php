<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderTempCommission extends Model
{
    protected $guarded = [];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop','shop_id');
    }
    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'order_id');
    }
}
