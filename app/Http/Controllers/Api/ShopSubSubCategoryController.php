<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsListCollection;
use App\Model\Product;
use App\Model\Shop;
use App\Model\ShopSubcategory;
use App\Model\ShopSubSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopSubSubCategoryController extends Controller
{
    public function getShopSubSubcategories(Request $request) {
        $shopSubSubcategories = DB::table('shop_sub_subcategories')
            ->Join('sub_subcategories','shop_sub_subcategories.subsubcategory_id','=','sub_subcategories.id')
            ->where('shop_sub_subcategories.shop_id',$request->shop_id)
            ->where('shop_sub_subcategories.category_id',$request->category_id)
            ->where('shop_sub_subcategories.subcategory_id',$request->subcategory_id)
            ->select('shop_sub_subcategories.subsubcategory_id as subsubcategory_id','shop_sub_subcategories.shop_id','shop_sub_subcategories.category_id as category_id','shop_sub_subcategories.subcategory_id as subcategory_id','sub_subcategories.name as subsubcategory_name')
            ->get();
        if (!empty($shopSubSubcategories))
        {
            return response()->json(['success'=>true,'response'=> $shopSubSubcategories], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function getFeaturedProducts(Request $request) {
        $shop = Shop::find($request->shop_id);
        $shopSubSubcategories = ShopSubSubcategory::where('subsubcategory_id',$request->subsubcategory_id)->where('shop_id',$shop->id)->first();
        return new ProductsListCollection(Product::where('published',1)->where('featured',1)->where('subsubcategory_id',$shopSubSubcategories->subsubcategory_id)->where('user_id',$shop->user_id)->latest()->get());
    }
    public function getAllProducts(Request $request) {
        $shop = Shop::find($request->shop_id);
        $shopSubSubcategories = ShopSubSubcategory::where('subsubcategory_id',$request->subsubcategory_id)->where('shop_id',$shop->id)->first();
        return new ProductsListCollection(Product::where('published',1)->where('subsubcategory_id',$shopSubSubcategories->subsubcategory_id)->where('user_id',$shop->user_id)->latest()->get());
    }
}
