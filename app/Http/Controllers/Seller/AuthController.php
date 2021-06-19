<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\Seller;
use App\Model\Shop;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function ShowRegForm()
    {
        return view('auth.seller.register');
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name' =>  'required',
            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users',
            'email' =>  'required|email|unique:users,email',
            'password' =>  'required|confirmed|min:6',
            //'store_name' => 'required',
            'address' =>'required'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = "seller";
        $user->referral_code = mt_rand(000000,999999);
        $user->referred_by = $request->referred_by;
        $user->banned = 1;
        $user->password = Hash::make($request->password);
        $user->save();
        $defaultCommissionPercent = BusinessSetting::where('type', 'seller_commission')->first();
        $seller = new Seller;
        $seller->user_id = $user->id;
        $seller->commission = $defaultCommissionPercent->value;
        $seller->save();
        if(Shop::where('user_id', $user->id)->first() == null){
            $shop = new Shop;
            $shop->user_id = $user->id;
            $shop->seller_id = $seller->id;
            $shop->name = $request->shop_name;
            $shop->slug = Str::slug($request->shop_name).'-'.$user->id;
            $shop->address = $request->address;
            $shop->city = $request->city;
            $shop->area = $request->area;
            $shop->latitude = $request->latitude;
            $shop->longitude = $request->longitude;
            if($request->hasFile('logo')){
                $shop->logo = $request->logo->store('uploads/shop/logo');
            }
            $shop->save();
        }

        Session::put('phone',$user->phone);
        Session::put('password',$user->password);
        Session::put('user_type','seller');

        Toastr::success('Successfully Registered!');
        return redirect()->route('get-verification-code',$user->id);

    }
}
