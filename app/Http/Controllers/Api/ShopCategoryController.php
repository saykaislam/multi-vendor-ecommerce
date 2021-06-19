<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Shop;
use App\Model\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopCategoryController extends Controller
{
    public  function getShopCategories() {
        $shopCategories = ShopCategory::all();
        if (!empty($shopCategories))
        {
            return response()->json(['success'=>true,'response'=> $shopCategories], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function getShopCategory($id) {

        $shopCats = DB::table('shop_categories')
            ->Join('categories','shop_categories.category_id','=','categories.id')
            ->where('shop_categories.shop_id',$id)
            ->select('shop_categories.category_id as category_id','shop_categories.shop_id','categories.name as category_name','categories.icon as category_image')
            ->get();
        if (!empty($shopCats))
        {
            return response()->json(['success'=>true,'response'=> $shopCats], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
}
