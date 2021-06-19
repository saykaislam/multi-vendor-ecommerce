<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Review;
use App\Model\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VendorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:get-all-vendors', ['only' => ['index']]);
        $this->middleware('permission:seller-order-report', ['only' => ['sellerReport','sellerOrderDetails']]);
        $this->middleware('permission:top-ratted-shop', ['only' => ['topRatedShop']]);
    }
    public function index() {
       //echo "Hello";
        return view('backend.admin.vendor.index');
    }

    public function indexTest(){
        return view('backend.admin.vendor.index2');
    }

    public function sellerReport() {
        $sellers = User::where('user_type','seller')->where('verification_code','!=',null)->latest()->get();
        $orders = null;
        $sellerId = null;
        $deliveryStatus = null;
        return view('backend.admin.vendor.seller_report',compact('sellers','orders','sellerId','deliveryStatus'));
    }
    public function sellerOrderDetails(Request $request) {
        $sellers = User::where('user_type','seller')->where('verification_code','!=',null)->latest()->get();
        if (!empty($request->seller_id && $request->delivery_status)){
            $sellerId = $request->seller_id;
            $shop = Shop::where('user_id',$sellerId)->first();
            $deliveryStatus = $request->delivery_status;
            $orders = Order::where('shop_id',$shop->id)->where('delivery_status',$deliveryStatus)->latest()->get();
            return view('backend.admin.vendor.seller_report',compact('sellers','orders','sellerId','deliveryStatus'));
        }
        return redirect()->back();
    }

    public function nearestShp(Request $request)
    {
        $vendors = Shop::all();
        return response()->json(['success'=> true, 'response'=>$vendors]);
    }

public function topRatedShop()
{
    $reviews = DB::table('reviews')
        //->where('stock_transfer_id', $stock_transfer_id)
        ->join('shops','shops.id','=','reviews.shop_id')
        ->select('reviews.shop_id',DB::raw('SUM(reviews.rating) as total_rating'))
        ->groupBy('reviews.shop_id')
        ->orderBy('total_rating', 'DESC')
        ->get();
//    dd($reviews);
    return view('backend.admin.Top_rated_shop.index',compact('reviews'));
}

}
