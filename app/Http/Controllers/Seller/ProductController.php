<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Helpers;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Color;
use App\Model\Product;
use App\Model\ProductStock;
use App\Model\Shop;
use App\Model\ShopBrand;
use App\Model\ShopCategory;
use App\Model\ShopSubcategory;
use App\Model\ShopSubSubcategory;
use App\Model\Subcategory;
use App\Model\SubSubcategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id',Auth::id())->latest()->get();
        return view('backend.seller.products.index',compact('products'));
    }
    public function ajaxSlugMake($name)
    {
        $data = Str::slug($name);
        return response()->json(['success'=> true, 'response'=>$data]);
    }
    public function ajaxSubCat (Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return $subcategories;
    }
    public function ajaxSubSubCat(Request $request)
    {
        $subsubcategories = SubSubcategory::where('sub_category_id', $request->subcategory_id)->get();
        return $subsubcategories;
    }
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('backend.seller.products.create',compact('categories','brands'));
    }
    public function sku_combination(Request $request)
    {
        //dd($request->all());
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $my_str = implode('', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = Helpers::combinations($options);
        return view('backend.partials.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
    }
    public function store(Request $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->added_by = $request->added_by;
        $product->user_id = Auth::id();
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->subsubcategory_id = $request->subsubcategory_id;
        $product->brand_id = $request->brand_id;
        $product->tags = implode('|',$request->tags);
        $product->published = 0;
        $product->admin_permission = 0;
        if ($request->current_stock == 1){
            $product->current_stock = 100000;
        }else{
            $product->current_stock = 0;
        }
        $photos = array();
        if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
                //ImageOptimizer::optimize(base_path('public/').$path);
            }
            $product->photos = json_encode($photos);
        }

        if($request->hasFile('thumbnail_img')){
            $product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');
            //ImageOptimizer::optimize(base_path('public/').$product->thumbnail_img);
        }

        $product->unit = $request->unit;
        $product->description = $request->description;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->purchase_price = $request->purchase_price;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->vat = $request->vat;
        $product->vat_type = $request->vat_type;
        $product->labour_cost = $request->labour_cost;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->slug = $request->slug.'-'.Str::random(5);

        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $data = Array();
            foreach ($request->colors as $color){
                $colorName = Color::where('code',$color)->first();
                $color_item['name'] = $colorName->name;
                $color_item['code'] = $color;
                array_push($data, $color_item);
            }
            $product->colors = json_encode($data);
        }
        else {
            $colors = array();
            $product->colors = json_encode($colors);
        }
        //choice option data
        $choice_options = array();
        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_'.$no;

                $item['attribute_id'] = $no;
                $item['values'] = explode(',', implode('|', $request[$str]));

                array_push($choice_options, $item);
            }
        }

        if (!empty($request->choice_no)) {
            $product->attributes = json_encode($request->choice_no);
        }
        else {
            $product->attributes = json_encode(array());
        }
        $product->choice_options = json_encode($choice_options);

        $product->save();

        //combinations start
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $my_str = implode('|',$request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        //Generates the combinations of customer choice options
        $combinations = Helpers::combinations($options);
        if(count($combinations[0]) > 0){
//            dd('inside seller controller after');
            $product->variant_product = 1;
            foreach ($combinations as $key => $combination){
                $str = '';
                foreach ($combination as $key => $item){
                    if($key > 0 ){
                        $str .= '-'.str_replace(' ', '', $item);
                    }
                    else{
                        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
                            $color_name = \App\Model\Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        }
                        else{
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                // $item = array();
                // $item['price'] = $request['price_'.str_replace('.', '_', $str)];
                // $item['sku'] = $request['sku_'.str_replace('.', '_', $str)];
                // $item['qty'] = $request['qty_'.str_replace('.', '_', $str)];
                // $variations[$str] = $item;

                $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
                if($product_stock == null){
                    $product_stock = new ProductStock;
                    $product_stock->product_id = $product->id;
                }

                $product_stock->variant = $str;
                $product_stock->price = $request['price_'.str_replace('.', '_', $str)];
                $product_stock->sku = $request['sku_'.str_replace('.', '_', $str)];
                /*$product_stock->qty = $request['qty_'.str_replace('.', '_', $str)];*/
                if ($request->current_stock == 1){
                    $product_stock->qty = 100000;
                }else{
                    $product_stock->qty = 0;
                }
                $product_stock->save();
            }
            //combinations end
            $product->save();
            Toastr::success("Product Inserted Successfully","Success");
            return redirect()->route('seller.products.index');
        }
        //check shop categories
        $shopId = Shop::where('user_id',Auth::id())->first();
        $checkShopCategory = ShopCategory::where('shop_id',$shopId->id)->where('category_id',$request->category_id)->first();
        if(empty($checkShopCategory)){
            $shopCategoryData = new ShopCategory();
            $shopCategoryData->shop_id = $shopId->id;
            $shopCategoryData->category_id = $request->category_id;
            $shopCategoryData->save();
        }
        $shopSubcategory = ShopSubcategory::where('shop_id',$shopId->id)->where('subcategory_id',$request->subcategory_id)->where('category_id',$request->category_id)->first();
        if(empty($shopSubcategory)){
            $shopSubcategoryData = new ShopSubcategory();
            $shopSubcategoryData->shop_id = $shopId->id;
            $shopSubcategoryData->subcategory_id = $request->subcategory_id;
            $shopSubcategoryData->category_id = $request->category_id;
            $shopSubcategoryData->save();
        }

        $checkShopSubSubCategory = ShopSubSubcategory::where('shop_id',$shopId->id)->where('subsubcategory_id',$request->subsubcategory_id)->where('subcategory_id',$request->subcategory_id)->where('category_id',$request->subcategory_id)->first();
        if (empty($checkShopSubSubCategory)) {
            $shopSub_SubcategoryData = new ShopSubSubcategory();
            $shopSub_SubcategoryData->shop_id = $shopId->id;
            $shopSub_SubcategoryData->subsubcategory_id = $request->subsubcategory_id;
            $shopSub_SubcategoryData->subcategory_id = $request->subcategory_id;
            $shopSub_SubcategoryData->category_id = $request->category_id;
            $shopSub_SubcategoryData->save();
        }

        $shopBrand = ShopBrand::where('shop_id',$shopId->id)->where('brand_id',$request->brand_id)->first();
        if(empty($shopBrand)){
            $shopBrandData = new ShopBrand();
            $shopBrandData->shop_id = $shopId->id;
            $shopBrandData->brand_id = $request->brand_id;
            $shopBrandData->save();
        }
        $product->save();
        Toastr::success("Product Inserted Successfully","Success");
        return redirect()->route('seller.products.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product = Product::find(decrypt($id));
        //dd($product);
        return view('backend.seller.products.edit',compact('brands', 'categories','product'));
    }

    public function update(Request $request, $id)
    {
        //
    }
    public function update2(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->subsubcategory_id = $request->subsubcategory_id;
        $product->brand_id = $request->brand_id;
        $product->tags = implode('|',$request->tags);
        if ($request->current_stock == 1){
            $product->current_stock = 100000;
        }else{
            $product->current_stock = 0;
        }

        if($request->has('previous_photos')){
            $photos = $request->previous_photos;
        }
        else{
            $photos = array();
        }

        if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
                //ImageOptimizer::optimize(base_path('public/').$path);
            }
        }
        $product->photos = json_encode($photos);

        $product->thumbnail_img = $request->previous_thumbnail_img;
        //dd($request->previous_thumbnail_img);
        if($request->hasFile('thumbnail_img')){
            $product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');
            //ImageOptimizer::optimize(base_path('public/').$product->thumbnail_img);
        }
        $product->unit = $request->unit;
        $product->description = $request->description;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->purchase_price = $request->purchase_price;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->vat = $request->vat;
        $product->vat_type = $request->vat_type;
        $product->labour_cost = $request->labour_cost;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->slug = $request->slug.'-'.Str::random(5);
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $data = Array();
            foreach ($request->colors as $color){
                $colorName = Color::where('code',$color)->first();
                $color_item['name'] = $colorName->name;
                $color_item['code'] = $color;
                array_push($data, $color_item);
                //$data = array_push($colorName,$color);
            }
            //dd($data);
            $product->colors = json_encode($data);
        }
        else {
            $colors = array();
            $product->colors = json_encode($colors);
        }
        $choice_options = array();

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_'.$no;

                $item['attribute_id'] = $no;
                $item['values'] = explode(',', implode('|', $request[$str]));

                array_push($choice_options, $item);
            }
        }
        if($product->attributes != json_encode($request->choice_attributes)){
            foreach ($product->stocks as $key => $stock) {
                $stock->delete();
            }
        }

        if (!empty($request->choice_no)) {
            $product->attributes = json_encode($request->choice_no);
        }
        else {
            $product->attributes = json_encode(array());
        }
        $product->choice_options = json_encode($choice_options);

        //combinations start
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $my_str = implode('|',$request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = Helpers::combinations($options);
        if(count($combinations[0]) > 0){
            $product->variant_product = 1;
            foreach ($combinations as $key => $combination){
                $str = '';
                foreach ($combination as $key => $item){
                    if($key > 0 ){
                        $str .= '-'.str_replace(' ', '', $item);
                    }
                    else{
                        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
                            $color_name = \App\Model\Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        }
                        else{
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }

                $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
                if($product_stock == null){
                    $product_stock = new ProductStock;
                    $product_stock->product_id = $product->id;
                }

                $product_stock->variant = $str;
                $product_stock->price = $request['price_'.str_replace('.', '_', $str)];
                $product_stock->sku = $request['sku_'.str_replace('.', '_', $str)];
                /*$product_stock->qty = $request['qty_'.str_replace('.', '_', $str)];*/
                if ($request->current_stock == 1){
                    $product_stock->qty = 100000;
                }else{
                    $product_stock->qty = 0;
                }
                $product_stock->save();
            }
        }
        $product->save();
        Toastr::success("Product Updated Successfully","Success");
        return redirect()->route('seller.products.index');

    }

    public function destroy($id)
    {
        //
    }
    //today's deals update
    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }
    //product published
    public function updatePublished(Request $request)
    {
        //return 'ok';
        $product = Product::find($request->id);
        $product->published = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }
    //featured product status updated
    public function updateFeatured(Request $request)
    {
        $product = Product::find($request->id);
        $product->featured = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }
    public function getAdminProductAjax()
    {
        $sellerP = Product::where('added_by','seller')->where('user_id',Auth::id())->select('aPId_to_seller')->get();
        $products = Product::where('added_by','admin')->latest()->select('id','name','unit_price','thumbnail_img')->latest()->get();
        $arr = array();
        $check2 = array();
        foreach ($products as $product){
            $data = $sellerP->contains('aPId_to_seller', $product->id);
           if (!$data){
                $check2['id'] = $product->id;
                $check2['image'] = $product->thumbnail_img;
                $check2['name'] = $product->name;
                $check2['unit_price'] = $product->unit_price;
                array_push($arr, $check2);
           }
        }
        //return $arr;
        $alldata = array();
        foreach($arr as $single){
            $alldata[] = array(
                (string)$single['id'],
                '<img src="'.url($single['image']).'" alt="Girl in a jacket" width="50" height="40">',
                $single['name'],
                (string)$single['unit_price']
            );
        }
        $Response = array('data' => $alldata );
        return response()->json($Response);
    }
    public function getAdminProduct()
    {
        return view('backend.seller.products.product_list_form_admin');
    }
    public function getAdminProductStore(Request $request)
    {
        foreach ($request->id as $data){
            $product = Product::find($data);
            $product_new = $product->replicate();
            $product_new->added_by = 'seller';
            $product_new->user_id = Auth::id();
            $product_new->aPId_to_seller = $product->id;
            $product_new->slug = substr($product_new->slug, 0, -5).Str::random(5);
            $product_new->save();
            if($product->variant_product == 1){
                $stockProducts = ProductStock::where('product_id', $product->id)->get();
                foreach ($stockProducts as $stockProduct){
                    $new_stockProduct = $stockProduct->replicate();
                    $new_stockProduct->product_id = $product_new->id;
                    $new_stockProduct->save();
                }
            }

            //check shop categories
            $shopId = Shop::where('user_id',Auth::id())->first();
            $checkShopCategory = ShopCategory::where('shop_id',$shopId->id)->where('category_id',$product_new->category_id)->first();
            if(empty($checkShopCategory)){
                $shopCategoryData = new ShopCategory();
                $shopCategoryData->shop_id = $shopId->id;
                $shopCategoryData->category_id = $product_new->category_id;
                $shopCategoryData->save();
            }
            $shopSubcategory = ShopSubcategory::where('shop_id',$shopId->id)->where('subcategory_id',$product_new->subcategory_id)->where('category_id',$product_new->subcategory_id)->first();
//            $shopCategory = ShopCategory::where('shop_id',$shopId->id)->where('category_id',$product_new->category_id)->first();
            if (empty($shopSubcategory)) {
                $shopSubcategoryData = new ShopSubcategory();
                $shopSubcategoryData->shop_id = $shopId->id;
                $shopSubcategoryData->subcategory_id = $product_new->subcategory_id;
                $shopSubcategoryData->category_id = $product_new->category_id;
                $shopSubcategoryData->save();
            }

            //check shop sub sub_categories
            $checkShopSubSubCategory = ShopSubSubcategory::where('shop_id',$shopId->id)->where('subsubcategory_id',$product_new->subsubcategory_id)->where('subcategory_id',$product_new->subcategory_id)->where('category_id',$product_new->subcategory_id)->first();
            if (empty($checkShopSubSubCategory)) {
                $shopSub_SubcategoryData = new ShopSubSubcategory();
                $shopSub_SubcategoryData->shop_id = $shopId->id;
                $shopSub_SubcategoryData->subsubcategory_id = $product_new->subsubcategory_id;
                $shopSub_SubcategoryData->subcategory_id = $product_new->subcategory_id;
                $shopSub_SubcategoryData->category_id = $product_new->category_id;
                $shopSub_SubcategoryData->save();
            }

            $shopBrand = ShopBrand::where('shop_id',$shopId->id)->where('brand_id',$product_new->brand_id)->first();
            if(empty($shopBrand)){
                $shopBrandData = new ShopBrand();
                $shopBrandData->shop_id = $shopId->id;
                $shopBrandData->brand_id = $product_new->brand_id;
                $shopBrandData->save();
            }
        }
        Toastr::success('Product Successfully Copied!');
        return redirect()->back();
    }
    public function sku_combination_edit(Request $request)
    {
        /* dd($request->all());*/
        $product = Product::find($request->id);
        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = Helpers::combinations($options);
        return view('backend.partials.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }
}
