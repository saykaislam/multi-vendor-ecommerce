<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Payment;
use App\Model\Product;
use App\Model\Seller;
use App\Model\SellerWithdrawRequest;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $seller = Seller::where('user_id',Auth::id())->first();
        $all_payment = Payment::where('seller_id',$seller->id)->latest()->get();
        return view('backend.seller.payment_history.index',compact('all_payment'));
    }

    public function money()
    {
        $seller = Seller::where('user_id',Auth::id())->first();
        $payment = SellerWithdrawRequest::where('user_id', Auth::id())->latest()->get();
//        dd($payment);
        return view('backend.seller.money_withdraw.index',compact('seller','payment'));
    }

    public function store(Request $request)
    {
        $seller = Seller::where('user_id',Auth::id())->first();
        if($seller->admin_to_pay >= $request->amount ) {
        $new_pay = new SellerWithdrawRequest();
        $new_pay->user_id= Auth::id();
        $new_pay->amount = $request->amount;
        $new_pay->message = $request->message;
        $new_pay->status = 0;
        $new_pay->save();
        $seller->admin_to_pay -= $request->amount;
        $seller->save();
        Toastr::success("Request Inserted Successfully", "Success");
        return redirect()->back();
        } else {
            Toastr::error("You do not have enough balance to send withdraw request");
            return redirect()->back();
        }

    }
    public function paymentReport(){
        $shop = Shop::where('user_id',Auth::id())->first();
        $todayProfit = Order::where('delivery_status','Completed')->where('shop_id',$shop->id)->whereDate('created_at',Carbon::today())->get()->sum('profit');
        $totalProfit = Order::where('delivery_status','Completed')->where('shop_id',$shop->id)->get()->sum('profit');
        $monthlyProfits = Order::where('delivery_status','Completed')->where('shop_id',$shop->id)->latest()->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('y-m'); // grouping by years
//return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        return view('backend.seller.payment_report.index',compact('monthlyProfits','todayProfit','totalProfit'));
    }
}
