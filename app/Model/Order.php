<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function order_details()
    {
        return $this->hasOne('App\Model\OrderDetails', 'order_id');

    }
    public function OrderTempCommission()
    {
        return $this->hasOne('App\Model\OrderTempCommission', 'order_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');

    }
    public function shop()
    {
        return $this->belongsTo('App\Model\Shop', 'shop_id');

    }
}
