<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\FavoriteShop;
use App\Model\Wishlist;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlistAdd($id)
    {
        if (Auth::user())
        {
            $check = Wishlist::where('product_id', $id)->where('user_id', Auth::id())->first();

            if(empty($check)){
                $wishList = new Wishlist();
                $wishList->product_id = $id;
                $wishList->user_id = Auth::id();
                $wishList->save();
                Toastr::success('This product added in your wishlist');
                return redirect()->back();

            }else{
                Toastr::warning('This product already added in your wishlist');
                return redirect()->back();
            }
        }else{
            Toastr::warning('Login first to add wishlist');
            return redirect()->back();
        }
    }
    public function wishlist(){
        $wishlists = Wishlist::where('user_id', Auth::id())->latest()->get();
        return view('frontend.user.wishlist', compact('wishlists'));
    }
    public function wishlistRemove($id)
    {
        $wl = Wishlist::find($id);
        $wl->delete();
        Toastr::success('This product remove from wishlist');
        return redirect()->back();
    }
}
