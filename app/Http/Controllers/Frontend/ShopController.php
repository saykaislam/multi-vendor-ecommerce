<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(){
        $shops = DB::table('shops')
            ->join('sellers','shops.seller_id','=','sellers.id')
            ->where('sellers.verification_status','=',1)
            ->select('shops.*')
            ->latest()
            ->get();
        return view('frontend.pages.shop.shop_lists',compact('shops'));
    }
    public function nearestshop(Request $request) {
        //dd($request->all());
        $lat=$request->lat;
        $lng=$request->lng;
        $shops=Shop::whereBetween('latitude',[$lat-0.01,$lat+0.01])->whereBetween('longitude',[$lng-0.01,$lng+0.01])->get();
        return response()->json(['success'=> true, 'response'=>$shops]);
    }
    public function bestSellerShopList() {
        $orders = DB::table('orders')
            ->join('shops','shops.id','=','orders.shop_id')
            ->join('sellers','shops.user_id','=','sellers.user_id')
            ->where('sellers.verification_status','=',1)
            ->select('orders.shop_id',DB::raw('SUM(orders.grand_total) as total_amount'))
            ->groupBy('orders.shop_id')
            ->orderBy('total_amount', 'DESC')
            ->get();
        return view('frontend.pages.shop.best_seller_shop_list',compact('orders'));
    }

}
