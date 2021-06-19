<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:business-settings', ['only' => ['index','commissionUpdate','refferalValueUpdate','firstOrderValueUpdate']]);

    }
    public function index(){
        $sellerCommission = BusinessSetting::where('type','seller_commission')->first();
        $refferalValue = BusinessSetting::where('type','refferal_value')->first();
        $firstOrderDiscount = BusinessSetting::where('type','first_order_discount')->first();
        return view('backend.admin.business.index',compact('sellerCommission','refferalValue','firstOrderDiscount'));
    }
    public function commissionUpdate(Request $request){
        //dd($request->all());
        $sellerCommission = BusinessSetting::find($request->id);
        $sellerCommission->value = $request->value;
        $sellerCommission->save();
    }
    public function refferalValueUpdate(Request $request){
        $refferalValue = BusinessSetting::find($request->id);
        $refferalValue->value = $request->value;
        $refferalValue->save();
    }
    public function firstOrderValueUpdate(Request $request){
        $firstOrderValue = BusinessSetting::find($request->id);
        $firstOrderValue->value = $request->value;
        $firstOrderValue->save();
    }
}
