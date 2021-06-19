<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SellerWithdrawRequest extends Model
{
    public function seller()
    {
        return $this->belongsTo('App\Model\Seller', 'user_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
