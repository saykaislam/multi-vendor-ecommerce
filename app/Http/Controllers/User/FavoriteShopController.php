<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\FavoriteShop;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteShopController extends Controller
{
    public function favoriteShop($id){
        $shop = Shop::find($id);
        if (Auth::user())
        {
//            $check = FavoriteShop::where('user_id', Auth::id())->where('shop_id', $shop->id)->first();
                $favoriteShop = new FavoriteShop();
                $favoriteShop->user_id = Auth::id();
                $favoriteShop->shop_id= $shop->id;
                $favoriteShop->save();
                return redirect()->back();
        }else{
            Toastr::warning('Login first to Follow');
            return redirect()->back();
        }
    }
    public function removeFavoriteShop($id) {

        $shop = Shop::find($id);
        $favoriteShop = FavoriteShop::where('user_id', Auth::id())->where('shop_id', $shop->id)->first();
        $favoriteShop->delete();
        return redirect()->back();
    }
}
