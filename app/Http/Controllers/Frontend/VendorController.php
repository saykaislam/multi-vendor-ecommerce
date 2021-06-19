<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\FavoriteShop;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\Product;
use App\Model\Review;
use App\Model\Seller;
use App\Model\Shop;
use App\Model\ShopBrand;
use App\Model\ShopCategory;
use App\Model\ShopSubcategory;
use App\Model\ShopSubSubcategory;
use App\Model\Subcategory;
use App\Model\SubSubcategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index() {
        return view('frontend.pages.vendor.become_vendor');
    }
    public function singleshop($slug) {
        $shop=Shop::where('slug',$slug)->first();
        $seller = Seller::where('user_id',$shop->user_id)->first();
        $user = User::where('id',$shop->user_id)->first();
        $products=Product::where('added_by','seller')->where('user_id',$shop->user_id)->where('published',1)->where('featured',1)->latest()->take(8)->get();
        $best_sales_products=Product::where('added_by','seller')->where('user_id',$shop->user_id)->where('published',1)->where('num_of_sale', '>',0)->orderBy('num_of_sale', 'DESC')->limit(8)->get();
        $todaysDeal = Product::where('added_by','seller')->where('user_id',$shop->user_id)->where('published',1)->where('todays_deal',1)->latest()->take(8)->get();
        $flashDeal = FlashDeal::where('status',1)->where('user_type','admin')->where('featured',1)->first();
        if(!empty($flashDeal)){
            $flashDealProducts = FlashDealProduct::where('user_id',$shop->user_id)->where('flash_deal_id',$flashDeal->id)->latest()->take(7)->get();
        }else{
            $flashDealProducts = null;
        }
        $favoriteShop = FavoriteShop::where('user_id', Auth::id())->where('shop_id', $shop->id)->first();

        //dd($flashDealProducts);
        $shopCat=ShopCategory::where('shop_id',$shop->id)->latest()->get();
//        dd($products);
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
        //dd($totalRatingCount);

        //dd($totalRatingCount);
        return view('frontend.pages.vendor.vendor_store',
            compact('shop','user','products','todaysDeal','shopCat',
                'best_sales_products','seller','flashDeal','flashDealProducts','favoriteShop','totalRatingCount'
            )
        );
    }

    public function allCategories($slug){
        $shop = Shop::where('slug',$slug)->first();
        $user = User::where('id',$shop->user_id)->first();
        $shopCategories = ShopCategory::where('shop_id',$shop->id)->get();
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
        $favoriteShop = FavoriteShop::where('user_id', Auth::id())->where('shop_id', $shop->id)->first();
        return view('frontend.pages.vendor.view_all_categories',compact('shop','user','shopCategories','totalRatingCount','favoriteShop'));
    }
    public function categoryProducts($name,$slug) {
        $shop = Shop::where('slug',$name)->first();
        $user = User::where('id',$shop->user_id)->first();
        $category = Category::where('slug',$slug)->first();
//        $shopCat = ShopCategory::where('shop_id',$shop->id)->where('category_id',$category->id)->first();
        $shopSubcategories = ShopSubcategory::where('shop_id',$shop->id)->where('category_id',$category->id)->latest()->get();

        $featuredProducts = Product::where('category_id',$category->id)->where('user_id',$shop->user_id)->where('published',1)->where('featured',1)->latest()->take(8)->get();
        $products = Product::where('category_id',$category->id)->where('user_id',$shop->user_id)->where('published',1)->latest()->paginate(36);
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
        $favoriteShop = FavoriteShop::where('user_id', Auth::id())->where('shop_id', $shop->id)->first();
        return view('frontend.pages.vendor.category_by_product',compact('shop','user','featuredProducts','products','category','shopSubcategories','favoriteShop','totalRatingCount'));
    }
    public function subCategoryProducts($slug, $cat, $sub){
        $shop = Shop::where('slug',$slug)->first();
        $user = User::where('id',$shop->user_id)->first();
        $category = Category::where('slug',$cat)->first();
        $subCategory = Subcategory::where('slug',$sub)->first();
        $subSubCategories = ShopSubSubcategory::where('shop_id',$shop->id)->where('subcategory_id',$subCategory->id)->latest()->get();

        $featuredProducts = Product::where('subcategory_id',$subCategory->id)->where('user_id',$shop->user_id)->where('featured',1)->where('published',1)->latest()->take(8)->get();
        $products = Product::where('subcategory_id',$subCategory->id)->where('user_id',$shop->user_id)->where('published',1)->latest()->paginate(36);
        $fiveStarRev = Review::where('shop_id',$shop->id)->where('rating',5)->where('status',1)->sum('rating');
        $fourStarRev = Review::where('shop_id',$shop->id)->where('rating',4)->where('status',1)->sum('rating');
        $threeStarRev = Review::where('shop_id',$shop->id)->where('rating',3)->where('status',1)->sum('rating');
        $twoStarRev = Review::where('shop_id',$shop->id)->where('rating',2)->where('status',1)->sum('rating');
        $oneStarRev = Review::where('shop_id',$shop->id)->where('rating',1)->where('status',1)->sum('rating');
        $totalRating = Review::where('shop_id',$shop->id)->sum('rating');
        if ($totalRating > 0){
            $rating = (5*$fiveStarRev + 4*$fourStarRev + 3*$threeStarRev + 2*$twoStarRev + 1*$oneStarRev) / ($totalRating);
            $totalRatingCount = number_format((float)$rating, 1, '.', '');
        }else{
            $totalRatingCount =number_format((float)0, 1, '.', '');
        }

        $favoriteShop = FavoriteShop::where('user_id', Auth::id())->where('shop_id', $shop->id)->first();
        return view('frontend.pages.vendor.subcategory_by_products',compact('shop','user','category','subCategory','subSubCategories','featuredProducts','products','totalRatingCount','favoriteShop'));

    }
    public function subSubCategoryProducts($shop, $cat, $sub, $subsub ){
        $shop = Shop::where('slug',$shop)->first();
        $user = User::where('id',$shop->user_id)->first();
        $category = Category::where('slug',$cat)->first();
        $subCategory = Subcategory::where('slug',$sub)->first();
        $subsubCategory = SubSubcategory::where('slug',$subsub)->first();
//        $subSubCategories = ShopSubSubcategory::where('shop_id',$shop->id)->where('subcategory_id',$subCategory->id)->latest()->get();

        $featuredProducts = Product::where('subsubcategory_id',$subsubCategory->id)->where('subcategory_id',$subCategory->id)->where('user_id',$shop->user_id)->where('featured',1)->where('published',1)->latest()->take(8)->get();
        $products = Product::where('subsubcategory_id',$subsubCategory->id)->where('subcategory_id',$subCategory->id)->where('user_id',$shop->user_id)->where('published',1)->latest()->paginate(36);
        $fiveStarRev = Review::where('shop_id',$shop->id)->where('rating',5)->where('status',1)->sum('rating');
        $fourStarRev = Review::where('shop_id',$shop->id)->where('rating',4)->where('status',1)->sum('rating');
        $threeStarRev = Review::where('shop_id',$shop->id)->where('rating',3)->where('status',1)->sum('rating');
        $twoStarRev = Review::where('shop_id',$shop->id)->where('rating',2)->where('status',1)->sum('rating');
        $oneStarRev = Review::where('shop_id',$shop->id)->where('rating',1)->where('status',1)->sum('rating');
        $totalRating = Review::where('shop_id',$shop->id)->sum('rating');
        if ($totalRating > 0){
            $rating = (5*$fiveStarRev + 4*$fourStarRev + 3*$threeStarRev + 2*$twoStarRev + 1*$oneStarRev) / ($totalRating);
            $totalRatingCount = number_format((float)$rating, 1, '.', '');
        }else{
            $totalRatingCount =number_format((float)0, 1, '.', '');
        }

        $favoriteShop = FavoriteShop::where('user_id', Auth::id())->where('shop_id', $shop->id)->first();
        return view('frontend.pages.vendor.subsubcategory_by_products',compact('shop','user','category','subCategory','subsubCategory','featuredProducts','products','totalRatingCount','favoriteShop'));
    }
    public function search_product(Request $request){
        $storeId =  $request->get('storeId');
        $name = $request->get('q');
        $shops = Shop::find($storeId);
        //dd($shops);
        $product = Product::where('user_id',$shops->user_id)->where('added_by','seller')->where('name', 'LIKE', '%'. $name. '%')->where('published',1)->orWhere('tags', 'like', '%'.$name.'%')->limit(5)->get();
        return $product;
    }
    public function search_category_product(Request $request){
        $storeId =  $request->get('storeId');
        $name = $request->get('q');
        $catId = $request->get('catId');
        $category = Category::find($catId);
        $shop = Shop::find($storeId);
        $product = Product::where('name', 'LIKE', '%'. $name. '%')->where('user_id',$shop->user_id)->where('category_id',$category->id)->where('added_by','seller')->where('published',1)->orWhere('tags', 'like', '%'.$name.'%')->limit(5)->get();
        return $product;
    }
    public function search_subcategory_product(Request $request){
        $storeId =  $request->get('storeId');
        $name = $request->get('q');
        $subCatId = $request->get('subCatId');
        $catId = $request->get('CatId');
        $category = Category::find($catId);
        $subcategory = Subcategory::find($subCatId);
        $shop = Shop::find($storeId);
        $product = Product::where('name', 'LIKE', '%'. $name. '%')->where('user_id',$shop->user_id)->where('category_id',$category->id)->where('subcategory_id',$subcategory->id)->where('added_by','seller')->where('published',1)->orWhere('tags', 'like', '%'.$name.'%')->limit(5)->get();
        return $product;
    }
    public function productFilter($data, $shopId)
    {
        $shop = Shop::find($shopId);
//        dd($shop);
        $data2 = explode(',',$data);
        $data_min = (int) $data2[0];
        $data_max = (int) $data2[1];
        $products = Product::where('user_id',$shop->user_id)->where('unit_price', '>=', $data_min)->where('unit_price', '<=', $data_max)->where('published',1)->where('featured',1)->latest()->take(24)->get();
        //dd($result_data);
        return view('frontend.pages.shop.products_filter_dataset', compact('products','shop'));
//        return $result_data;
    }
    public function FeaturedSubFilter($data,$id,$subId)
    {
        $shop = Shop::find($id);
        $subcategory = Subcategory::find($subId);
//        $shopSubcategory = ShopSubcategory::where('');
//        dd($shops);
        $data2 = explode(',',$data);
        $data_min = (int) $data2[0];
        $data_max = (int) $data2[1];
        $products = Product::where('user_id',$shop->user_id)->where('subcategory_id',$subcategory->id)->where('unit_price', '>=', $data_min)->where('unit_price', '<=', $data_max)->where('published',1)->where('featured',1)->latest()->take(24)->get();
        return view('frontend.pages.shop.products_filter_dataset', compact('products','shop'));
    }
    public function flashdeal($slug) {
        $flashDeal = FlashDeal::where('slug',$slug)->where('status',1)->where('featured',1)->first();
//        $shop = Shop::where('user_id',$flashDeal->user_id)->first();
        $flashDealProducts = FlashDealProduct::where('flash_deal_id',$flashDeal->id)->latest()->get();
        return view('frontend.pages.shop.flash_deals_products',compact('flashDealProducts','flashDeal','shop'));
    }
    public function todaysDeal($slug) {
        $shop = Shop::where('slug',$slug)->first();
        $shopCategories = ShopCategory::where('shop_id',$shop->id)->latest()->get();
        $shopBrands = ShopBrand::where('shop_id',$shop->id)->latest()->get();
        $products = Product::where('added_by','seller')->where('user_id',$shop->user_id)->where('published',1)->where('todays_deal',1)->latest()->paginate(24);
        return view('frontend.pages.shop.todays_deal_products',compact('shop','shopCategories','shopBrands','products'));
    }
    public function todaysDealSubCategory($name,$slug,$sub) {
//        dd('sffk');
        $shop = Shop::where('slug',$name)->first();
        $category= Category::where('slug',$slug)->first();
        $subcategory = Subcategory::where('slug',$sub)->first();
        $shopCat = ShopCategory::where('shop_id',$shop->id)->latest()->get();
        $shopBrand = ShopBrand::where('shop_id',$shop->id)->latest()->get();
        $products = Product::where('category_id',$category->id)->where('subcategory_id',$subcategory->id)->where('user_id',$shop->user_id)->where('published',1)->where('todays_deal',1)->latest()->paginate(24);
//        dd($products);
        return view('frontend.pages.shop.todays_deal_by_subcategory',compact('shop','category','subcategory','shopBrand','shopCat','products'));
    }
    public function todaysDealFilter($data,$shopId)
    {
        $shop = Shop::find($shopId);
//        dd($shop);
        $data2 = explode(',',$data);
        $data_min = (int) $data2[0];
        $data_max = (int) $data2[1];
        $products = Product::where('user_id',$shop->user_id)->where('unit_price', '>=', $data_min)->where('unit_price', '<=', $data_max)->where('published',1)->where('todays_deal',1)->latest()->take(24)->get();
        return view('frontend.pages.shop.products_filter_dataset', compact('products','shop'));
//        return $result_data;
    }
    public function todaysDealSubFilter($data,$id,$subId)
    {
        $shop = Shop::find($id);
        $subcategory = Subcategory::find($subId);
//        $shopSubcategory = ShopSubcategory::where('');
//        dd($shops);
        $data2 = explode(',',$data);
        $data_min = (int) $data2[0];
        $data_max = (int) $data2[1];
        $products = Product::where('user_id',$shop->user_id)->where('subcategory_id',$subcategory->id)->where('unit_price', '>=', $data_min)->where('unit_price', '<=', $data_max)->where('published',1)->where('todays_deal',1)->latest()->take(24)->get();
        return view('frontend.pages.shop.products_filter_dataset', compact('products','shop'));
//        return $result_data;
    }
    public function bestSelling($slug) {
        $shop = Shop::where('slug',$slug)->first();
        $shopCategories = ShopCategory::where('shop_id',$shop->id)->latest()->get();
        $shopBrands = ShopBrand::where('shop_id',$shop->id)->latest()->get();
        $products = Product::where('added_by','seller')->where('user_id',$shop->id)->where('published',1)->where('num_of_sale', '>',0)->orderBy('num_of_sale', 'DESC')->latest()->paginate(24);
        return view('frontend.pages.shop.best_selling_products',compact('shop','shopCategories','shopBrands','products'));
    }
    public function bestSellingSubCategory($name,$slug,$sub) {
//dd('hhj');
        $shop = Shop::where('slug',$name)->first();
        $category= Category::where('slug',$slug)->first();
        $subcategory = Subcategory::where('slug',$sub)->first();
        $shopCat = ShopCategory::where('shop_id',$shop->id)->latest()->get();
        $shopBrand = ShopBrand::where('shop_id',$shop->id)->latest()->get();
        $products = Product::where('category_id',$category->id)->where('subcategory_id',$subcategory->id)->where('user_id',$shop->user_id)->where('published',1)->where('num_of_sale', '>',0)->orderBy('num_of_sale', 'DESC')->latest()->paginate(24);
        return view('frontend.pages.shop.best_selling_by_subcategory',compact('shop','category','subcategory','shopBrand','shopCat','products'));
    }
    public function bestSellingFilter($data,$shopId)
    {
        $shop = Shop::find($shopId);
//        dd($shops);
        $data2 = explode(',',$data);
        $data_min = (int) $data2[0];
        $data_max = (int) $data2[1];
        $products = Product::where('user_id',$shop->user_id)->where('unit_price', '>=', $data_min)->where('unit_price', '<=', $data_max)->where('published',1)->where('num_of_sale', '>',0)->orderBy('num_of_sale', 'DESC')->latest()->take(24)->get();
        return view('frontend.pages.shop.products_filter_dataset', compact('products','shop'));
//        return $result_data;
    }
    public function bestSellingSubFilter($data,$id,$subId)
    {
        $shop = Shop::find($id);
        $subcategory = Subcategory::find($subId);
//        $shopSubcategory = ShopSubcategory::where('');
//        dd($shops);
        $data2 = explode(',',$data);
        $data_min = (int) $data2[0];
        $data_max = (int) $data2[1];
        $products = Product::where('user_id',$shop->user_id)->where('subcategory_id',$subcategory->id)->where('unit_price', '>=', $data_min)->where('unit_price', '<=', $data_max)->where('published',1)->where('num_of_sale', '>',0)->orderBy('num_of_sale', 'DESC')->latest()->take(24)->get();
        return view('frontend.pages.shop.products_filter_dataset', compact('products','shop'));
//        return $result_data;
    }
    public function brandFilter($data,$id,$brndId)
    {
        $shop = Shop::find($id);
        $brand = Brand::find($brndId);
        $data2 = explode(',',$data);
        $data_min = (int) $data2[0];
        $data_max = (int) $data2[1];
        $products = Product::where('user_id',$shop->user_id)->where('brand_id',$brand->id)->where('unit_price', '>=', $data_min)->where('unit_price', '<=', $data_max)->where('published',1)->latest()->take(24)->get();
        return view('frontend.pages.shop.products_filter_dataset', compact('products','shop'));
//        return $products;
    }
}
