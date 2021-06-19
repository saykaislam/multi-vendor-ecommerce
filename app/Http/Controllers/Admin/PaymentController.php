<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use App\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:due-to-seller', ['only' => ['dueToSeller','dueToSellerDetails']]);
        $this->middleware('permission:due-to-admin', ['only' => ['dueToAdmin','dueToAdminDetails']]);


    }
    public function dueToSeller(){
        $sellers = User::where('user_type','seller')->where('verification_code','!=',null)->latest()->get();
        $sellerInfo = null;
        $sellerId = null;
        return view('backend.admin.seller.due_to_seller',compact('sellers','sellerInfo','sellerId'));
    }
    public function dueToSellerDetails(Request $request){
        $sellers = User::where('user_type','seller')->where('verification_code','!=',null)->latest()->get();
        if (!empty($request->seller_id)){
            $sellerId = $request->seller_id;
            $sellerInfo = Seller::where('user_id',$sellerId)->first();
//            $orders = Order::where('shop_id',$shop->id)->where('delivery_status',$deliveryStatus)->latest()->get();
            return view('backend.admin.seller.due_to_seller',compact('sellers','sellerInfo','sellerId'));
        }
        return redirect()->back();
    }
    public function dueToAdmin(){
        $sellers = User::where('user_type','seller')->where('verification_code','!=',null)->latest()->get();
        $sellerInfo = null;
        $sellerId = null;
        return view('backend.admin.seller.due_to_admin',compact('sellers','sellerInfo','sellerId'));
    }
    public function dueToAdminDetails(Request $request){
        $sellers = User::where('user_type','seller')->where('verification_code','!=',null)->latest()->get();
        if (!empty($request->seller_id)){
            $sellerId = $request->seller_id;
            $sellerInfo = Seller::where('user_id',$sellerId)->first();
//            $orders = Order::where('shop_id',$shop->id)->where('delivery_status',$deliveryStatus)->latest()->get();
            return view('backend.admin.seller.due_to_admin',compact('sellers','sellerInfo','sellerId'));
        }
        return redirect()->back();
    }
}
