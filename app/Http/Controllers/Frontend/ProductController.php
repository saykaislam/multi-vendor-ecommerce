<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\Product;
use App\Model\ProductStock;
use App\Model\Review;
use App\Model\Shop;
use App\Model\ShopBrand;
use App\Model\ShopCategory;
use App\Model\ShopSubcategory;
use App\Model\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function ProductDetails($slug) {
        $productDetails = Product::where('slug',$slug)->first();
        $attributes=json_decode($productDetails->attributes);
        $options=json_decode($productDetails->choice_options);
        $colors=json_decode($productDetails->colors);
        $photos=json_decode($productDetails->photos);

        $relatedBrands = Product::where('brand_id', $productDetails->brand_id)->where('user_id',$productDetails->user_id)->where('added_by','seller')->latest()->take(3)->where('published',1)->get();
        $categories = Product::where('category_id',$productDetails->category_id)->where('user_id',$productDetails->user_id)->where('added_by','seller')->where('published',1)->latest()->take(7)->get();
        $reviews = Review::where('product_id',$productDetails->id)->where('status',1)->get();
        $reviewsComments = Review::where('product_id',$productDetails->id)->where('status',1)->latest()->paginate(5);
        $fiveStarRev = Review::where('product_id',$productDetails->id)->where('rating',5)->where('status',1)->get();
        $fourStarRev = Review::where('product_id',$productDetails->id)->where('rating',4)->where('status',1)->get();
        $threeStarRev = Review::where('product_id',$productDetails->id)->where('rating',3)->where('status',1)->get();
        $twoStarRev = Review::where('product_id',$productDetails->id)->where('rating',2)->where('status',1)->get();
        $oneStarRev = Review::where('product_id',$productDetails->id)->where('rating',1)->where('status',1)->get();
//dd($colors);
        $flashSales =  $flashSales = FlashDealProduct::where('product_id',$productDetails->id)->first();
        $variant=ProductStock::where('product_id',$productDetails->id)->first();
        if(!empty($variant)){
            $price = home_discounted_base_price($productDetails->id);
            /*$price=$variant->price;*/
            $avilability=$variant->qty;
        }elseif(!empty($flashSales)){
            $price = home_discounted_base_price($productDetails->id);
            /*$price=$variant->price;*/
            $avilability = $productDetails->current_stock;
        }elseif ($productDetails->discount > 0){
            $price = home_discounted_base_price($productDetails->id);
            /*$price=$variant->price;*/
            $avilability = $productDetails->current_stock;
        }
        else{
            $price = $productDetails->unit_price;
            $avilability = $productDetails->current_stock;
        }
        return view('frontend.pages.shop.product_details',
            compact('productDetails','attributes','options','colors','price',
                'avilability','photos','relatedBrands','categories','reviews','fiveStarRev','fourStarRev',
                'threeStarRev','twoStarRev','oneStarRev','reviewsComments')
        );
    }

    public function ProductVariantPrice(Request  $request) {
        //dd($request->all());


        $c=count($request->variant);
        $i=1;
        $var=$request->variant;
        $v=[];
        for($i=1;$i<$c-1;$i++){
            array_push($v,$var[$i]['value']);
        }
        //dd(implode("-", $v));
        $variant=ProductStock::where('variant',implode("-", $v))->first();
        //dd($variant);
        $product = Product::find($variant->product_id);
        if ($product->discount > 0){
            $price = $variant->price;
            if($product->discount_type == 'percent'){

                $price -= ($variant->price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
            $variant['price'] = $price;
        }else{
            $variant=ProductStock::where('variant',implode("-", $v))->first();
        }

        return response()->json(['success'=> true, 'response'=>$variant]);
    }
    public function featuredProductList($slug) {
        $shop = Shop::where('slug',$slug)->first();
        $categories = ShopCategory::where('shop_id',$shop->id)->latest()->get();
        $shopBrands = ShopBrand::where('shop_id',$shop->id)->latest()->get();

        $products = Product::where('added_by','seller')->where('user_id',$shop->id)->where('published',1)->where('featured',1)->latest()->paginate(24);
//        $products = Product::where('added_by','seller')->where('user_id',$shop->user_id)->where('published',1)->latest()->paginate(24);
        return view('frontend.pages.shop.featured_product_list',compact('shop','categories','shopBrands','products'));
    }
    public function productSubCategory($name,$slug,$sub) {
        $shop = Shop::where('slug',$name)->first();
        $category= Category::where('slug',$slug)->first();
        $subcategory = Subcategory::where('slug',$sub)->first();
        $shopCategories = ShopCategory::where('shop_id',$shop->id)->latest()->get();
        $shopBrand = ShopBrand::where('shop_id',$shop->id)->latest()->get();
        $products = Product::where('category_id',$category->id)->where('subcategory_id',$subcategory->id)->where('user_id',$shop->user_id)->where('published',1)->where('featured',1)->latest()->paginate(24);
        return view('frontend.pages.shop.products_by_subcategory',compact('shop','category','subcategory','shopBrand','shopCategories','products'));
    }
    public function productByBrand($name,$slug) {
        $shop = Shop::where('slug',$name)->first();
        $brand = Brand::where('slug',$slug)->first();
        $shopCat = ShopCategory::where('shop_id',$shop->id)->latest()->get();
        $shopBrands = ShopBrand::where('shop_id',$shop->id)->latest()->get();
        $products = Product::where('brand_id',$brand->id)->where('user_id',$shop->user_id)->where('published',1)->latest()->paginate(24);
        return view('frontend.pages.shop.products_by_brands',compact('shop','brand','shopCat','shopBrands','products'));

    }
    public function bestSellsProducts() {

    }
}
