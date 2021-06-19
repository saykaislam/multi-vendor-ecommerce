<?php

namespace App\Http\Controllers\Frontend;
use App\Helpers\UserInfo;
use App\Model\BusinessSetting;
use App\Model\Category;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\Offer;
use App\Model\Order;
use App\Model\Product;
use App\Model\Seller;
use App\Model\Shop;
use App\Model\Subcategory;
use App\Model\VerificationCode;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index() {
        $categories = Category::where('is_home',1)->latest()->take(4)->get();
        $products = Product::where('todays_deal',1)->latest()->limit(7)->get();
        $all_products = Product::where('published',1)->latest()->get();
        $best_sales_products=Product::where('added_by','seller')->where('published',1)->where('num_of_sale', '>',0)->limit(20)->orderBy('num_of_sale','DESC')->get();
        $offers = Offer::latest()->take(3)->get();
        $orders = DB::table('orders')
            ->join('shops','shops.id','=','orders.shop_id')
            ->join('sellers','shops.user_id','=','sellers.user_id')
            ->where('sellers.verification_status','=',1)
            ->select('orders.shop_id',DB::raw('SUM(orders.grand_total) as total_amount'))
            ->groupBy('orders.shop_id')
            ->orderBy('total_amount', 'DESC')
            ->take(8)
            ->get();
        $flashDeal = FlashDeal::where('status',1)->where('user_type','admin')->where('featured',1)->first();
        if(!empty($flashDeal)){
            $flashDealProducts = FlashDealProduct::where('flash_deal_id',$flashDeal->id)->latest()->take(10)->get();
        }else{
            $flashDealProducts = null;
        }

        return view('frontend.pages.index', compact('categories','products','all_products','orders','best_sales_products','offers','flashDeal','flashDealProducts'));
    }
    public function register(Request $request) {
        $this->validate($request, [
            'name' =>  'required',
            'email' =>  'required|email|unique:users,email',
            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users',
            'password' => 'required|min:6',
        ]);
        $phn1 = (int)$request->phone;
        $check = User::where('phone',$phn1)->first();
        if (!empty($check)){
            Toastr::error('This phone number already exist');
            return back();
        }
        $refferalValue = BusinessSetting::where('type','refferal_value')->first();
        $userReg = new User();
        $userReg->name = $request->name;
        $userReg->email = $request->email;
        $userReg->phone= $request->phone;
        $userReg->password = Hash::make($request->password);
        $userReg->user_type = 'customer';
        $userReg->referral_code = mt_rand(000000,999999);
        $userReg->referred_by = $request->referred_by;

        if ($userReg->referred_by !=null) {
            $userReg->balance = $refferalValue->value;
            $refferal_by_user = User::find($request->refferal_by);
            $refferal_by_user->balance += $refferalValue->value;
            $refferal_by_user->save();
        }
        $userReg->banned = 1;
        $userReg->save();
//        dd($userReg);


        Session::put('phone',$request->phone);
        Session::put('password',$request->password);
        Session::put('user_type','customer');


        Toastr::success('Your registration successfully done!');
        return redirect()->route('get-verification-code',$userReg->id);
//        $credential = [
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => $request->password,
//        ];
//        if (Auth::attempt($credential)) {
//            return redirect()->route('user.dashboard');
//        }

    }
    public function getPhoneNumber(){
        return view('auth.password_verification.check_phone_number');
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
           Toastr::success('Thank you for your registration. We send a verification code in your mobile number. please verify your phone number.' ,'Success');
           //$verCode = $verCode->phone;
           //dd($text);
           return view('auth.password_verification.send_otp',compact('verCode'));
       }else{
           Toastr::error('This phone number does not exist to the system');
           return redirect()->back();
       }
    }
    public function otpStore(Request $request) {
        if ($request->isMethod('post')){
            $check = VerificationCode::where('code',$request->code)->where('phone',$request->phone)->where('status',0)->first();
            if (!empty($check)) {
                $check->status = 1;
                $check->update();
                $user = User::where('phone',$request->phone)->first();
                $user->verification_code = $request->code;
                $user->banned = 0;
                $user->save();
                Toastr::success('Your phone number successfully verified.' ,'Success');
                return view('auth.password_verification.reset_password',compact('user'));
            }else{
                //$verCode = $request->phone;
                $verCode = VerificationCode::where('phone',$request->phone)->where('status',0)->first();
                Toastr::error('Invalid Code' ,'Error');
                return view('auth.password_verification.send_otp',compact('verCode'));
            }
        }
    }
    public function passwordUpdate(Request $request, $id) {
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        Toastr::success('Your Password Updated successfully verified.' ,'Success');
        return redirect()->route('login');
    }
    public function referCode($code){
        $refferal_by = User::where('referral_code',$code)->first();
//        $referralCode = $code;
       return view('auth.register_with_refferal_code',compact('refferal_by'));
    }



    public function popupDataSet()
    {
        Session::put('popup', 1);
        return 1;
    }
    public function popupDataDestroy()
    {
        Session::forget('popup');
        return 1;
    }

}
