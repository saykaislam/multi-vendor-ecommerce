<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetails;
use App\Model\OrderTempCommission;
use App\Model\Seller;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:all-order-list', ['only' => ['index']]);
        $this->middleware('permission:pending-order-list', ['only' => ['pendingOrder']]);
        $this->middleware('permission:on-review-order-list', ['only' => ['onReviewedOrder']]);
        $this->middleware('permission:on-delivered-order-list', ['only' => ['onDeliveredOrder']]);
        $this->middleware('permission:delivered-order-list', ['only' => ['deliveredOrder']]);
        $this->middleware('permission:completed-order-list', ['only' => ['completedOrder']]);
        $this->middleware('permission:canceled-order-list', ['only' => ['canceledOrder']]);
        $this->middleware('permission:order-details', ['only' => ['orderDetails']]);
        $this->middleware('permission:order-status-change', ['only' => ['OrderProductChangeStatus']]);
        $this->middleware('permission:order-invoice-print', ['only' => ['orderInvoicePrint']]);
        $this->middleware('permission:daily-order-list', ['only' => ['dailyOrders']]);

    }

    public function index(){
        $orders = Order::latest()->get();
        $areaWiseOrders = null;
        return view('backend.admin.order_management.all_orders',compact('orders','areaWiseOrders'));
    }
    public function search_area(Request $request){
        $name = $request->get('q');
        $area = Order::where('area', 'LIKE', '%'. $name. '%')->limit(5)->get();
        return $area;
    }
    public function areaWiseOrder($area){
        $areaWiseOrders = Order::where('area',$area)->latest()->get();
        return view('backend.admin.order_management.all_orders', compact('areaWiseOrders'));
    }
    public function pendingOrder() {
        $pending_order = Order::where('delivery_status','Pending')->latest()->get();
        return view('backend.admin.order_management.pending_order',compact('pending_order'));
    }

    public function onReviewedOrder() {
        $onReview = Order::where('delivery_status','On review')->latest()->get();
        return view('backend.admin.order_management.on_review',compact('onReview'));
    }
    public function onDeliveredOrder() {
        $onDeliver= Order::where('delivery_status','On delivered')->latest()->get();
        return view('backend.admin.order_management.on_delivered',compact('onDeliver'));
    }
    public function deliveredOrder() {
        $Delivered= Order::where('delivery_status','Delivered')->latest()->get();
        return view('backend.admin.order_management.delivered',compact('Delivered'));
    }
    public function completedOrder() {
        $Completed= Order::where('delivery_status','Completed')->latest()->get();
        return view('backend.admin.order_management.completed',compact('Completed'));
    }
    public function canceledOrder() {
        $Canceled= Order::where('delivery_status','Cancel')->latest()->get();
        return view('backend.admin.order_management.canceled',compact('Canceled'));
    }
    public function orderDetails($id) {
        $order= Order::find(decrypt($id));
        if($order->view == 0){
            $order->view = 1;
            $order->save();
        }
        $shop = Shop::where('id',$order->shop_id)->first();
        $orderDetails= OrderDetails::where('order_id',$order->id)->get();
        return view('backend.admin.order_management.order_details',compact('order','orderDetails','shop'));
    }
    public function OrderProductChangeStatus(Request $request, $id)
    {

        $order = Order::find($id);
        $order->delivery_status = $request->delivery_status;
        $order->save();
        if ($request->delivery_status == 'Completed'){
            $tempCommission = OrderTempCommission::where('order_id',$id)->first();
            //dd($tempCommission);
            $shop = Shop::find($tempCommission->shop_id);
            $seller = Seller::where('user_id',$shop->user_id)->first();
            $seller->admin_to_pay += $tempCommission->temp_commission_to_seller;
            $seller->seller_will_pay_admin += $tempCommission->temp_commission_to_admin;
            $seller->save();
            $tempCommission->temp_commission_to_seller = 0.00;
            $tempCommission->temp_commission_to_admin = 0.00;
            $tempCommission->save();
            $order->payment_status = 'Paid';
            $order->save();
        }elseif ($request->delivery_status == 'Cancel'){
            $tempCommission = OrderTempCommission::where('order_id',$id)->first();
            $shop = Shop::find($tempCommission->shop_id);
            $seller = Seller::where('user_id',$shop->user_id)->first();
            $seller->admin_to_pay += 0;
            $seller->seller_will_pay_admin += 0;
            $seller->save();
            $tempCommission->temp_commission_to_seller = 0;
            $tempCommission->temp_commission_to_admin = 0;
            $tempCommission->save();
        }
        Toastr::success('Delivery status successfully changed');
        return redirect()->back();
    }
    public function orderInvoicePrint($id){
        $order = Order::find(decrypt($id));
        return view('backend.admin.order_management.invoice_print',compact('order'));
    }
    public function dailyOrders(){
        $DailyOrders = Order::select('id', 'created_at')
            ->latest()
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('d-m-y'); // grouping by day
            });
        //return  $DailyOrders;
        return view('backend.admin.order_management.daily_order',compact('DailyOrders'));
    }


}
