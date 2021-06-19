<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Product;
use App\Model\Seller;
use App\Model\Shop;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function profile() {
//        $shops = Shop::where('user_id',Auth::id())->first();
        $userInfo = User::where('id',Auth::id())->first();
        $sellerInfo = Seller::where('user_id',Auth::id())->first();
        $shopInfo = Shop::where('user_id',Auth::id())->first();
        $totalProducts = Product::where('user_id',Auth::id())->count();
        $totalOrders = Order::where('shop_id',$shopInfo->id)->count();
        $totalSoldAmount = Order::where('shop_id',$shopInfo->id)->where('payment_status','paid')->where('delivery_status','Completed')->sum('grand_total');
        return view('backend.seller.profile.profile',compact('userInfo','sellerInfo','shopInfo','totalProducts','totalOrders','totalSoldAmount'));
    }
    public function profile_update(Request $request,$id) {
        $this->validate($request, [
            'name' =>  'required',
            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users,phone,'.$id,
            'email' =>  'required|email|unique:users,email,'.$id,
            'avatar_original' =>  'mimes:jpeg,jpg,png,gif|max:100',
        ]);
        $user = User::findOrFail(Auth::id());
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if($request->hasFile('avatar_original')){
            $user->avatar_original = $request->avatar_original->store('uploads/profile');
        }
        $user->update();
        Toastr::success('Successfully Updated!');
        return redirect()->back();
    }
    public function password() {

        return view('backend.seller.profile.edit_password');
    }
    public function password_update(Request $request) {
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password Updated Successfully','Success');
                Auth::logout();
                return redirect()->route('login');
            } else {
                Toastr::error('New password cannot be the same as old password.', 'Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password not match.', 'Error');
            return redirect()->back();
        }
    }
    public function payment() {
        $pay = Seller::where('user_id',Auth::id())->first();
        return view('backend.seller.profile.payment', compact('pay'));
    }
    public function payment_update(Request $request) {
        $payment= Seller::where('user_id',Auth::id())->first();
        if(empty($payment)) {
            $new_pay = new Seller();
            $new_pay->bank_name = $request->bank_name;
            $new_pay->bank_acc_name = $request->bank_acc_name;
            $new_pay->bank_acc_no = $request->bank_acc_no;
            $new_pay->bank_routing_no = $request->bank_routing_no;
            $new_pay->cash_on_delivery_status = 0;
            $new_pay->bank_payment_status = 0;
            $new_pay->save();
            Toastr::success("Seller Bank Info Inserted Successfully","Success");
            return redirect()->back();
        }else {
            $payment->bank_name = $request->bank_name;
            $payment->bank_acc_name = $request->bank_acc_name;
            $payment->bank_acc_no = $request->bank_acc_no;
            $payment->bank_routing_no = $request->bank_routing_no;
            $payment->update();
            Toastr::success("Seller Bank Info Updated Successfully","Success");
            return redirect()->back();

        }
    }
    public function cashOnDelivery(Request $request)
    {
        //return 'ok';
        $payment = Seller::find($request->id);
        $payment->cash_on_delivery_status = $request->status;
        if($payment->save()){
            return 1;
        }
        return 0;
    }
    public function bankPayment(Request $request)
    {
        //return 'ok';
        $payment = Seller::find($request->id);
        $payment->bank_payment_status = $request->status;
        if($payment->save()){
            return 1;
        }
        return 0;
    }
}
