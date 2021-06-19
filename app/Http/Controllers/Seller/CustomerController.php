<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Review;
use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index() {
        $shop = Shop::where('user_id',Auth::id())->first();
//        $customers = Order::where('shop_id',$shop->id)->latest()->get();
        $customers = DB::table('users')
            ->join('orders','users.id','=','orders.user_id')
            ->where('orders.shop_id','=',$shop->id)
            ->get();
        return view('backend.seller.customer.index',compact('shop','customers'));
    }
    public function customerReview(){
        $shop = Shop::where('user_id',Auth::id())->first();
        $reviews = Review::where('shop_id',$shop->id)->latest()->get();
        return view('backend.seller.customer.review',compact('reviews'));
    }
}
