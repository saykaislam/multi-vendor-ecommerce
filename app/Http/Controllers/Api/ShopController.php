<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Review;
use App\Model\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public  function getShop()
    {
        $shops= Shop::all();
        if (!empty($shops))
        {
            return response()->json(['success'=>true,'response'=> $shops], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function getShopByLatLng($lat, $lng)
    {
        $shops=Shop::whereBetween('latitude',[$lat-0.02,$lat+0.02])->whereBetween('longitude',[$lng-0.02,$lng+0.02])->get();
        if (!empty($shops)){
            return response()->json(['success'=> true, 'response'=>$shops],200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function getShopRatings($id){
        $shop = Shop::find($id);
        $fiveStarRev = Review::where('shop_id',$shop->id)->where('rating',5)->where('status',1)->sum('rating');
        $fourStarRev = Review::where('shop_id',$shop->id)->where('rating',4)->where('status',1)->sum('rating');
        $threeStarRev = Review::where('shop_id',$shop->id)->where('rating',3)->where('status',1)->sum('rating');
        $twoStarRev = Review::where('shop_id',$shop->id)->where('rating',2)->where('status',1)->sum('rating');
        $oneStarRev = Review::where('shop_id',$shop->id)->where('rating',1)->where('status',1)->sum('rating');
        $totalRating = Review::where('shop_id',$shop->id)->sum('rating');

        //dd($fiveStarRev);
        if ($totalRating > 0){
            $rating = (5*$fiveStarRev + 4*$fourStarRev + 3*$threeStarRev + 2*$twoStarRev + 1*$oneStarRev) / ($totalRating);
            $totalRatingCount = number_format((float)$rating, 1, '.', '');
        }else{
            $totalRatingCount =number_format((float)0, 1, '.', '');
        }
        if (!empty($totalRatingCount)){
            return response()->json(['success'=> true, 'response'=>$totalRatingCount],200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
