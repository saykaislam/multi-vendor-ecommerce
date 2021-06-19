<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\Seller;
use App\Model\Shop;
use App\Model\VerificationCode;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public $successStatus = 200;
    public $failStatus = 401;
    public function login(Request $request)
    {
        //dd($request->all());
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
            'banned' => 0,
        ];
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            $success['token'] = $user->createToken('mudihat')-> accessToken;
            $success['user'] = $user;
            if ($user->user_type == 'seller'){
                $seller = Seller::where('user_id',$user->id)->first();
                $shop = Shop::where('user_id',$user->id)->first();
                $success['seller_id'] = $seller->id;
                $success['shop_name'] = $shop->name;
                $success['verification_status'] = $seller->verification_status;
            }
            return response()->json(['success'=>true,'response' => $success], $this-> successStatus);
        }else{
            return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
        }
    }
    public function register(Request $request)
    {
        $userEmailCheck = User::where('email',$request->email)->first();
        $userPhoneCheck = User::where('phone',$request->phone)->first();

        if (!empty($userEmailCheck)){
            return response()->json(['success'=>true,'response' =>"This email already exist!"], 405);
        }
        if (!empty($userPhoneCheck)){
            return response()->json(['success'=>true,'response' =>"This number already exist!"], 405);
        }
        $refferalValue = BusinessSetting::where('type','refferal_value')->first();
        $userReg = new User();
        $userReg->name = $request->name;
        $userReg->email = $request->email;
        $userReg->phone = $request->phone;
        $userReg->password = Hash::make($request->password);
        $userReg->user_type = 'customer';
        $userReg->referral_code = mt_rand(000000,999999);
        $userReg->referred_by = $request->referral_code;
        if ($userReg->referred_by !=null) {
            $userReg->balance = $refferalValue->value;
            $refferal_by_user = User::where('referral_code', $request->referral_code)->first();
            $refferal_by_user->balance += $refferalValue->value;
            $refferal_by_user->save();
        }
        $userReg->banned = 1;
        $userReg->save();

        $verification = VerificationCode::where('phone',$userReg->phone)->first();
        if (!empty($verification)){
            $verification->delete();
        }
        $verCode = new VerificationCode();
        $verCode->phone = $userReg->phone;
        $verCode->code = mt_rand(1111,9999);
        $verCode->status = 0;
        $verCode->save();

        $text = "Dear ".$userReg->name.", Your MudiHat OTP is: ".$verCode->code;
        UserInfo::smsAPI("88".$verCode->phone,$text);
        if (!empty($userReg))
        {
            return response()->json(['success'=>true,'response'=> 'Registration Successful. Please enter OTP code. '], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
//        return response()->json(['success'=>true,'response' =>$success], $this-> successStatus);
    }

    public function sellerRegister(Request $request)
    {
        $sellerReg = new User();
        $sellerReg->name = $request->name;
        $sellerReg->email = $request->email;
        $sellerReg->phone = $request->phone;
        $sellerReg->password = Hash::make($request->password);
        $sellerReg->user_type = 'seller';
        $sellerReg->banned = 1;
        $sellerReg->save();
        $defaultCommissionPercent = BusinessSetting::where('type', 'seller_commission')->first();
        $seller = new Seller;
        $seller->user_id = $sellerReg->id;
        $seller->commission = $defaultCommissionPercent->value;
        $seller->save();
        if(Shop::where('user_id', $sellerReg->id)->first() == null){
            $shop = new Shop;
            $shop->user_id = $sellerReg->id;
            $shop->seller_id = $seller->id;
            $shop->name = $request->shop_name;
            $shop->slug = Str::slug($request->shop_name).'-'.$sellerReg->id;
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

        $verification = VerificationCode::where('phone',$sellerReg->phone)->first();
        if (!empty($verification)){
            $verification->delete();
        }
        $verCode = new VerificationCode();
        $verCode->phone = $sellerReg->phone;
        $verCode->code = mt_rand(1111,9999);
        $verCode->status = 0;
        $verCode->save();
        $text = "Dear ".$sellerReg->name.", Your MudiHat OTP is: ".$verCode->code;
        UserInfo::smsAPI("88".$verCode->phone,$text);
        $success['details'] = $sellerReg;
        return response()->json(['success'=>true,'response' =>$success], $this-> successStatus);
    }
    public function verificationStore(Request $request){
        if ($request->isMethod('post')){
            $check = VerificationCode::where('code',$request->code)->where('phone',$request->phone)->where('status',0)->first();
            if (!empty($check)) {
                $check->status = 1;
                $check->update();
                $user = User::where('phone',$request->phone)->first();
                $user->verification_code = $request->code;
                $user->banned = 0;
                $user->save();
                $success['message'] = 'Your phone number successfully verified';
//                $success['token'] = $user->createToken('mudihat')-> accessToken;
               return response()->json(['success'=>true,'response' =>$success], $this-> successStatus);
            }else{
                return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
            }
        }
    }
    public function resendOtp(Request $request) {
        $user = User::where('phone',$request->phone)->first();
        $verification = VerificationCode::where('phone',$request->phone)->first();
        if (!empty($verification)){
            $verification->delete();
        }
        $verCode = new VerificationCode();
        $verCode->phone = $request->phone;
        $verCode->code = mt_rand(1111,9999);
        $verCode->status = 0;
        $verCode->save();

        $text = "Dear ".$user->name.", Your MudiHat OTP is: ".$verCode->code;
        UserInfo::smsAPI("88".$verCode->phone,$text);
        if (!empty($user))
        {
            return response()->json(['success'=>true,'response'=> 'Please Submit the verification code.'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function CheckVerificationCode(Request $request){
        $check = VerificationCode::where('code', $request->code)->where('phone', Session::get('phone'))->where('status', 0)->first();
        if(!empty($check)){
            echo 'found';
        }else{
            echo 'not found';
        }
    }
    public function checkPhoneNumber(Request $request){
        $user = User::where('phone',$request->phone)->first();
        if (!empty($user)) {
            $verification = VerificationCode::where('phone',$user->phone)->first();
            if (!empty($verification)){
                $verification->delete();
            }
            $verCode = new VerificationCode();
            $verCode->phone = $user->phone;
            $verCode->code = mt_rand(1111,9999);
            $verCode->status = 0;
            $verCode->save();
            $text = "Dear ".$user->name.", Your Mudi Hat OTP is ".$verCode->code;
//        echo $text;exit();
            UserInfo::smsAPI("88".$verCode->phone,$text);
            $success['details'] = $user;
            return response()->json(['success'=>true,'response' =>$success], $this-> successStatus);
        }else{
            return response()->json(['success'=>false,'response'=>'This phone number does not exist to the system'], 401);
        }
    }
    public function passwordUpdate(Request $request) {
        $user = User::where('phone',$request->phone)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        if (!empty($user))
        {
            return response()->json(['success'=>true,'response'=> $user], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
