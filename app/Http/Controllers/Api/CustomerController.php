<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\FavoriteShop;
use App\Model\Order;
use App\Model\Shop;
use App\Model\Wishlist;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(){
        $totalOrder = Order::where('user_id',Auth::id())->count();
        $totalWishlist = Wishlist::where('user_id',Auth::id())->count();
        $data= [
            'Balance'=>Auth::User()->balance,
            'Cart'=>\Gloudemans\Shoppingcart\Facades\Cart::count(),
            'wishlist'=>$totalWishlist,
            'order'=>$totalOrder,
        ];
        if (!empty($data))
        {
            return response()->json(['success'=>true,'response'=> $data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function profileInfo(){
        $user = User::find(Auth::id());
        if (!empty($user))
        {
            return response()->json(['success'=>true,'response'=> $user], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function profileUpdate(Request $request){
//        $this->validate($request, [
//            'name' => 'required',
//            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users,phone,'.Auth::id(),
//            'email' =>  'required|email|unique:users,email,'.Auth::id(),
//        ]);
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->hasFile('avatar_original')){
            $user->avatar_original = $request->avatar_original->store('uploads/profile');
        }
        $user->save();
        if (!empty($user))
        {
            return response()->json(['success'=>true,'response'=> $user], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function passwordUpdate(Request $request) {
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(['success'=>true,'response'=> $user], 200);
            }else{
                return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
            }

        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function address(){
        $user = User::find(Auth::id());
        if (!empty($user->address))
        {
            return response()->json(['success'=>true,'response'=> $user->address], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
    public function addressUpdate(Request $request){
        $user = User::find(Auth::id());
        $user->address = $request->address;
        $user->save();
        if (!empty($user))
        {
            return response()->json(['success'=>true,'response'=> $user], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function wishlist(){
        $wishlists = DB::table('wishlists')
            ->join('products','wishlists.product_id','=','products.id')
            ->where('wishlists.user_id', Auth::user()->id)
            ->select('wishlists.id','wishlists.product_id','products.name','products.current_stock','products.unit_price','products.thumbnail_img')
            ->get();
//        return $wishlists;
            if (!empty($wishlists))
            {
                return response()->json(['success'=>true,'response'=> $wishlists], 200);
            }
            else{
                return response()->json(['success'=>false,'response'=> 'Wishlist is empty!'], 404);
            }
    }
    public function wishlistAdd($id){
//        return Auth::user();
        if (Auth::user()) {
            $check = Wishlist::where('product_id', $id)->where('user_id', Auth::id())->first();
            if (empty($check)) {
                $wishList = new Wishlist();
                $wishList->product_id = $id;
                $wishList->user_id = Auth::id();
                $wishList->save();
                return response()->json(['success' => true, 'response' => $wishList], 200);

            } else {
                return response()->json(['success' => false, 'response' => 'This Product already added to wishlist'], 404);
            }
        }else {
            return response()->json(['success' => false, 'response' => 'Login first to add wishlist'], 404);
        }
    }
    public function wishlistRemove($id){
        $wishlist = Wishlist::where('product_id', $id)->where('user_id', Auth::id())->first();
        if (!empty($wishlist))
        {
            $wishlist->delete();
            return response()->json(['success'=>true,'response'=> 'Wishlist deleted Successfully!!!'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Wishlist is empty!!!'], 404);
        }
    }
    public function getFavoriteShop(){
        $favoriteShop = DB::table('favorite_shops')
            ->join('shops','favorite_shops.shop_id','=','shops.id')
            ->select('shops.name as Shop_name','shops.logo as shop_logo','favorite_shops.*')
            ->get();
        if (!empty($favoriteShop))
        {
            return response()->json(['success'=>true,'response'=> $favoriteShop], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something Went Wrong'], 404);
        }
    }
    public function favoriteShopAdd(Request $request){
        $shop = Shop::find($request->shop_id);
        if (Auth::user())
        {
            $check = FavoriteShop::where('user_id', Auth::id())->where('shop_id', $shop->id)->first();
            if (!empty($check)){
                $check->delete();
            }
            $favoriteShop = new FavoriteShop();
            $favoriteShop->user_id = Auth::id();
            $favoriteShop->shop_id= $shop->id;
            $favoriteShop->save();
            return response()->json(['success'=>true,'response'=> $favoriteShop], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Login first to Follow!!'], 404);
        }
    }
    public function favoriteShopRemove(Request $request) {
//        $shop = Shop::find($request->shop_id);
        if (Auth::user()) {
            $favoriteShop = FavoriteShop::where('user_id', Auth::id())->where('shop_id', $request->shop_id)->first();
            $favoriteShop->delete();
            return response()->json(['success' => true, 'response' => 'Favorite Shop removed successfully!!'], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Login first to Follow!!'], 404);
        }
    }
}
