<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsListCollection;
use App\Model\Category;
use App\Model\Product;
use App\Model\Shop;
use App\Model\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public  function getCategories() {
        $categories = Category::all();
        if (!empty($categories))
        {
            return response()->json(['success'=>true,'response'=> $categories], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function featuredProducts(Request $request) {
        $shop = Shop::find($request->shop_id);
        $shopCategory = ShopCategory::where('category_id',$request->category_id)->where('shop_id',$shop->id)->first();
        return new ProductsListCollection(Product::where('category_id',$shopCategory->category_id)->where('user_id',$shop->user_id)->where('published',1)->where('featured',1)->latest()->get());
    }
    public function categoryAllProducts(Request $request) {
        $shop = Shop::find($request->shop_id);
        $shopCategory = ShopCategory::where('category_id',$request->category_id)->where('shop_id',$shop->id)->first();
        return new ProductsListCollection(Product::where('published',1)->where('category_id',$shopCategory->category_id)->where('user_id',$shop->user_id)->where('published',1)->latest()->get());
    }
}
