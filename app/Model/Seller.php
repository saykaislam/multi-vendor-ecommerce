<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->hasMany('App\Model\Product','user_id');
    }
    public function shop()
    {
        return $this->hasOne('App\Model\Shop','seller_id');
    }
}
