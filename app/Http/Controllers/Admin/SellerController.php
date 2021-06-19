<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AdminPaymentHistory;
use App\Model\AdminWithdrawRequest;
use App\Model\BusinessSetting;
use App\Model\Order;
use App\Model\Payment;
use App\Model\Product;
use App\Model\Seller;
use App\Model\SellerWithdrawRequest;
use App\Model\Shop;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SellerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:seller-list', ['only' => ['index']]);
        $this->middleware('permission:seller-verification', ['only' => ['verification']]);
        $this->middleware('permission:seller-commission-set', ['only' => ['commissionForm','commissionStore']]);
        $this->middleware('permission:admin-payment-history', ['only' => ['adminPaymentHistory']]);
        $this->middleware('permission:admin-payment-report', ['only' => ['adminPaymentReport']]);
        $this->middleware('permission:seller-profile', ['only' => ['profileShow','updateProfile','updatePassword','updateAddress','bankInfoUpdate']]);
        $this->middleware('permission:pay-to-seller', ['only' => ['payment_modal','pay_to_seller_commission']]);
        $this->middleware('permission:pay-to-admin', ['only' => ['admin_payment_modal','admin_withdraw_store']]);
        $this->middleware('permission:seller-payment-history', ['only' => ['paymentHistory']]);
        $this->middleware('permission:ban-seller', ['only' => ['banSeller']]);


    }
    public function index()
    {
        $sellerUserInfos = User::where('user_type','seller')->where('verification_code','!=',null)->latest()->get();
        $shops = null;
        return view('backend.admin.seller.index', compact('sellerUserInfos','shops'));
    }
    public function search_area(Request $request){
        $name = $request->get('q');
        $area = Shop::where('area', 'LIKE', '%'. $name. '%')->limit(5)->get();
        return $area;
    }
    public function areaWiseSeller($area){
        $shops = Shop::where('area',$area)->latest()->get();
        return view('backend.admin.seller.index', compact('shops'));
    }
    public function verification(Request $request)
    {
        //return $request->id;
        $seller = Seller::find($request->id);
        $seller->verification_status = $request->status;
        if($seller->save()){
            return 1;
        }
        return 0;
    }
    public function commissionForm()
    {
        $commission = BusinessSetting::where('type','seller_commission')->first();

        return view('backend.admin.seller.commission',compact('commission'));
    }

    public function commissionStore(Request $request, $id)
    {
        $this->validate($request,[
            'value' => 'required',
        ]);
        $data = BusinessSetting::find($id);
        $data->value = $request->value;
        $data->refferal_value = $request->refferal_value;
        $data->save();
        Toastr::success('Commission successfully added for all sellers and Customers');
        return redirect()->back();
    }
    public function adminPaymentHistory()
    {
        $paymentHistories = AdminPaymentHistory::latest()->get();
        return view('backend.admin.payment.admin_payment_history',compact('paymentHistories'));
    }
    public function adminPaymentReport($id)
    {
        $seller = Seller::find($id);
//        $todayProfit = Order::where('delivery_status','Completed')->where('shop_id',$shop->id)->whereDate('created_at',Carbon::today())->get()->sum('profit');
        $totalPayment = AdminPaymentHistory::where('seller_id', $seller->id)->get()->sum('amount');
        $monthlyPayments = AdminPaymentHistory::where('seller_id', $seller->id)->latest()->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('y-m'); // grouping by years
        });
        return view('backend.admin.payment.admin_payment_report',compact('totalPayment','monthlyPayments'));
    }
    public function paymentHistory()
    {
        $paymentHistories = Payment::latest()->get();
        return view('backend.admin.seller.payment_history',compact('paymentHistories'));
    }
    public function withdrawRequest()
    {
        $withdrawRequests = SellerWithdrawRequest::latest()->get();
        return view('backend.admin.seller.withdraw_request', compact('withdrawRequests'));
    }

    public function profileShow($id)
    {
        $userInfo = User::find(decrypt($id));
        $sellerInfo = Seller::where('user_id',$userInfo->id)->first();
        $shopInfo = Shop::where('user_id',$userInfo->id)->first();
        $totalProducts = Product::where('user_id',$userInfo->id)->count();
        $totalOrders = Order::where('shop_id',$shopInfo->id)->count();
        $totalSoldAmount = Order::where('shop_id',$shopInfo->id)->where('payment_status','paid')->where('delivery_status','Completed')->sum('grand_total');
        if($userInfo->view == 0){
            $userInfo->view = 1;
            $userInfo->save();
        }

        return view('backend.admin.seller.profile', compact('userInfo','sellerInfo','shopInfo','totalProducts','totalOrders','totalSoldAmount'));
    }
    public function updateProfile(Request $request, $id)
    {
        $this->validate($request, [
            'name' =>  'required',
            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users,phone,'.$id,
            'email' =>  'required|email|unique:users,email,'.$id,
        ]);

        $user =  User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        Toastr::success('Seller Profile Updated Successfully','Success');
        return redirect()->back();
    }
    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' =>  'required|confirmed|min:6',
        ]);

        $user =  User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        Toastr::success('Seller Password Updated Successfully','Success');
        return redirect()->back();
    }

    public function updateAddress(Request $request, $id){
        $this->validate($request, [
            'address' =>  'required',
        ]);
        $user =  User::find($id);
        $shop = Shop::where('user_id',$user->id)->first();
        $shop->address = $request->address;
        $shop->city = $request->city;
        $shop->area = $request->area;
        $shop->latitude = $request->latitude;
        $shop->longitude = $request->longitude;
        $shop->save();
        Toastr::success('Shop Address Updated Successfully','Success');
        return redirect()->back();
    }

    public function bankInfoUpdate(Request $request, $id)
    {
        //dd($request->all());
        $this->validate($request, [
            'bank_name' =>  'required',
            'bank_acc_name' =>  'required',
            'bank_acc_no' =>  'required',
            'bank_routing_no' =>  'required',
        ]);

        $serller =   Seller::find($id);
        $serller->bank_name =  $request->bank_name;
        $serller->bank_acc_name =  $request->bank_acc_name;
        $serller->bank_acc_no =  $request->bank_acc_no;
        $serller->bank_routing_no =  $request->bank_routing_no;
        $serller->save();
        Toastr::success('Seller Bank Info Updated Successfully','Success');
        return redirect()->back();
    }
    public function commission_modal(Request $request)
    {
        $seller = Seller::find($request->id);
        return view('backend.admin.seller.individual_seller_commission', compact('seller'));
    }
    public function individulCommissionSet(Request $request, $id)
    {
        $this->validate($request,[
            'commission' => 'required',
        ]);
        $data = Seller::find($id);
        $data->commission = $request->commission;
        $data->save();
        Toastr::success($request->commission.' % Seller Commission successfully added for all sellers');
        return redirect()->back();
    }
    public function payment_modal(Request $request)
    {
        $seller = Seller::find($request->id);
        return view('backend.admin.seller.payment_modal', compact('seller'));
    }
    public function admin_payment_modal(Request $request)
    {
        $seller = Seller::find($request->id);
        return view('backend.admin.seller.admin_payment_modal', compact('seller'));
    }
    public function admin_withdraw_store(Request $request, $id) {
        $seller = Seller::find($id);
//       dd($seller);
        if($seller->seller_will_pay_admin >= $request->amount ) {
            $payment = new AdminPaymentHistory();
            $payment->seller_id = $seller->id;
            $payment->amount = $request->amount;
            $payment->payment_method = $request->payment_option;;
            $payment->save();
            $seller->seller_will_pay_admin -= $request->amount;
            $seller->save();
            Toastr::success("Request Inserted Successfully", "Success");
            return redirect()->route('admin.payment.history');
        } else {
            Toastr::error("You do not have enough balance to send withdraw request");
            return redirect()->back();
        }
    }
    public function withdraw_payment_modal(Request $request)
    {
        //$seller = Seller::find($request->id);
        $withdrawData = SellerWithdrawRequest::find($request->id);
        $seller = Seller::where('user_id',$withdrawData->user_id)->first();
        //return $seller;
        return view('backend.admin.seller.withdraw_payment_modal', compact('seller','withdrawData'));
    }
    public function pay_to_seller_commission(Request $request)
    {
        $data['seller_id'] = $request->seller_id;
        $data['amount'] = $request->amount;
        $data['type'] = $request->type;
        $data['payment_method'] = $request->payment_option;
        //$data['payment_withdraw'] = $request->payment_withdraw;
        if ($data['type'] == 'withdraw'){
            $data['withdraw_request_id'] = $request->withdraw_request_id;
        }
        if ($request->txn_code != null) {
            $data['txn_code'] = $request->txn_code;
        }
        else {
            $data['txn_code'] = null;
        }
        $request->session()->put('payment_type', 'seller_payment');
        $request->session()->put('payment_data', $data);
        if ($request->payment_option == 'cash') {
            return $this->seller_payment_done($request->session()->get('payment_data'), null);
        }
        /*elseif ($request->payment_option == 'sslcommerz') {
            $sslcommerz = new PublicSslCommerzPaymentController;
            return $sslcommerz->index($request);
        }*/

    }

    public function seller_payment_done($payment_data, $payment_details){
        $seller = Seller::findOrFail($payment_data['seller_id']);
        if($payment_data['type'] == 'payment'){
            $seller->admin_to_pay = $seller->admin_to_pay - $payment_data['amount'];
            $seller->save();
        }

        $payment = new Payment;
        $payment->seller_id = $seller->id;
        $payment->amount = $payment_data['amount'];
        $payment->payment_method = $payment_data['payment_method'];
        $payment->txn_code = $payment_data['txn_code'];
        $payment->payment_details = $payment_details;
        $payment->save();

        if ($payment_data['type'] == 'withdraw') {
            $seller_withdraw_request = SellerWithdrawRequest::find($payment_data['withdraw_request_id']);
            $seller_withdraw_request->status = '1';
            $seller_withdraw_request->viewed = '1';
            $seller_withdraw_request->save();
        }

        Session::forget('payment_data');
        Session::forget('payment_type');

        if ($payment_data['type'] == 'payment') {
            Toastr::success('Payment completed', 'Success');
            return redirect()->route('admin.seller.payment.history');
        }else{
            Toastr::success('Payment completed', 'Success');
            return redirect()->route('admin.seller.withdraw.request');
        }

    }
    public function banSeller($id) {
        //dd($id);
        $user = User::findOrFail($id);
        $seller = Seller::where('user_id',$user->id)->first();
        //dd($seller);
        $seller->verification_status = 0;
        $seller->save();
        $user->banned = 1;
        $user->save();
        Toastr::success('Seller Baned ', 'Success');
        return redirect()->back();
    }
}
