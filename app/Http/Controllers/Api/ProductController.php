<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailCollection;
use App\Http\Resources\ProductsListCollection;
use App\Model\Color;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\Product;
use App\Model\Review;
use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getFeaturedProducts($id) {
        $shop = Shop::where('id',$id)->first();
        return new ProductsListCollection(Product::where('featured', 1)->where('user_id', $shop->user_id)->where('published',1)->latest()->get());
    }
    public function getTodaysDeal($id) {
        $shop = Shop::where('id',$id)->first();
        return new ProductsListCollection(Product::where('todays_deal', 1)->where('user_id', $shop->user_id)->where('published',1)->latest()->get());
    }
    public function getBestSales($id) {
        $shop = Shop::where('id',$id)->first();
        return new ProductsListCollection(Product::where('user_id', $shop->user_id)->where('published',1)->where('num_of_sale', '>',0)->orderBy('num_of_sale', 'DESC')->latest()->get());
    }
    public function getFlashDeals($id) {
        $shop = Shop::where('id',$id)->first();
        $flashDeal = FlashDeal::where('status',1)->where('user_id',$shop->user_id)->where('user_type','seller')->where('featured',1)->first();
        if (!empty($flashDeal))
        {
            return response()->json(['success'=>true,'response'=> $flashDeal], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function getRelatedProducts($id){
        $product = Product::find($id);
        return new ProductsListCollection(Product::where('category_id',$product->category_id)->where('user_id',$product->user_id)->where('featured', 1)->where('published',1)->latest()->get());
    }
    public function search_product(Request $request) {

        $storeId =  $request->shop_id;
        $name = $request->q;
        $shop = Shop::find($storeId);
        return new ProductsListCollection(Product::where('published',1)->where('name', 'LIKE', '%'. $name. '%')->where('user_id',$shop->user_id)->orWhere('tags', 'like', '%'.$name.'%')->latest()->get());
    }
    public function allReviews($id){
        $reviews = DB::table('reviews')
            ->join('users','reviews.user_id','=','users.id')
            ->where('reviews.product_id',$id)
            ->select('users.avatar_original as user_image','users.name as user_name','reviews.*')
            ->latest()
            ->get();
        if (!empty($reviews))
        {
            return response()->json(['success'=>true,'response'=> $reviews], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
    public function productDetails($id)
    {
        return new ProductDetailCollection(Product::where('id',$id)->get());
    }
    public function variantPrice(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $str = '';
        $tax = 0;

        if ($request->has('color')) {
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        foreach (json_decode($request->choice) as $option) {
            $str .= $str != '' ?  '-'.str_replace(' ', '', $option->name) : str_replace(' ', '', $option->name);
        }

        if($str != null && $product->variant_product){
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;
            $stockQuantity = $product_stock->qty;
        }
        else{
            $price = $product->unit_price;
            $stockQuantity = $product->current_stock;
        }

        //discount calculation
        $flash_deals = FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $key => $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                if($flash_deal_product->discount_type == 'percent'){
                    $price -= ($price*$flash_deal_product->discount)/100;
                }
                elseif($flash_deal_product->discount_type == 'amount'){
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }
        if (!$inFlashDeal) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

       /* if ($product->tax_type == 'percent') {
            $price += ($price*$product->tax) / 100;
        }
        elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }*/

        return response()->json([
            'product_id' => $product->id,
            'variant' => $str,
            'price' => (double) $price,
            'in_stock' => $stockQuantity < 1 ? false : true
        ]);
    }
}
