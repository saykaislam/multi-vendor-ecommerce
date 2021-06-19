<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Payment;
use App\Model\Seller;
use App\Model\SellerWithdrawRequest;
use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SellerPaymentController extends Controller
{
    public function pendingBalance() {
        $seller = Seller::where('user_id',Auth::id())->first();
        $success['Seller Pending Balance'] = $seller->admin_to_pay;
        if (!empty($seller))
        {
            return response()->json(['success'=>true,'response'=> $success], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function withdrawRequest(Request $request){
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
            $success['success'] = 'Request Inserted Successfully';
            $success['withdraw amount'] = $new_pay-> amount;
            $success['Pending Balance'] = $seller->admin_to_pay;
            $success['message'] = $new_pay->message;

            return response()->json(['success'=>true,'response'=> $success], 200);
        } else {
            return response()->json(['success'=>false,'response'=> 'You do not have enough balance to send withdraw request'], 404);
        }
    }
    public function withdrawRequestHistory(){
        $paymentHistory = SellerWithdrawRequest::where('user_id', Auth::id())->latest()->get();
        if (!empty($paymentHistory))
        {
            return response()->json(['success'=>true,'response'=> $paymentHistory], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function paymentHistory(){
        $seller = Seller::where('user_id',Auth::id())->first();
        $all_payment = Payment::where('seller_id',$seller->id)->latest()->get();
        if (!empty($all_payment))
        {
            return response()->json(['success'=>true,'response'=> $all_payment], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function paymentReport(){
        $shop = Shop::where('user_id',Auth::id())->first();
        $todayProfit = Order::where('delivery_status','Completed')->where('shop_id',$shop->id)->whereDate('created_at',Carbon::today())->get()->sum('profit');
        $totalProfit = Order::where('delivery_status','Completed')->where('shop_id',$shop->id)->get()->sum('profit');
//        $monthlyProfits = Order::where('delivery_status','Completed')->where('shop_id',$shop->id)->latest()->get()->groupBy(function($date) {
//            return Carbon::parse($date->created_at)->format('y-m'); // grouping by years
//        });
        $monthlyProfits = Order::where('delivery_status','Completed')
            ->where('shop_id',$shop->id)
            //->latest()
            ->get()
            ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('y-m'); // grouping by years
        });


        $month_amount = [];
        $month = [];

        if (!empty($monthlyProfits)){
            foreach ($monthlyProfits as $monthlyProfit){
                $nested_data = $monthlyProfit->sum('profit');
                array_push($month_amount, $nested_data);

            }
        }
        if (!empty($monthlyProfits)){
            foreach ($monthlyProfits as $monthlyProfit){
                $value2 = date('F, Y',strtotime($monthlyProfit[0]['created_at']));
                array_push($month,$value2);

            }
        }
        $success['amount'] = $month_amount;
        $success['date'] = $month;
        if (!empty($success))
        {
            return response()->json(['success'=>true,'response'=> $success], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
}
