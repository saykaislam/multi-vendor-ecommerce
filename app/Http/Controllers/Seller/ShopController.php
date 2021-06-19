<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShopController extends Controller
{

    public function index()
    {
        //
    }
    public function ajaxSlugMake($name)
    {
        $data = Str::slug($name);
        return response()->json(['success'=> true, 'response'=>$data]);
    }

    public function dataUpdate($data)
    {
        $shop_set = Shop::where('user_id',Auth::id())->first();
//        dd(Auth::id());
        return view('backend.seller.settings.shop.create',compact('shop_set'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $shop = Shop::where('user_id',Auth::id())->first();
        $shop->about = $request->about;
        $shop->shipping_time = $request->shipping_time;
        $shop->facebook = $request->facebook;
        $shop->google = $request->google;
        $shop->twitter = $request->twitter;
        $shop->youtube = $request->youtube;
        $shop->meta_title = $request->meta_title;
        $shop->meta_description = $request->meta_description;
        if($request->hasFile('logo')){
            $shop->logo = $request->logo->store('uploads/shop/logo');
            //ImageOptimizer::optimize(base_path('public/').$product->thumbnail_img);
        }
        $shop->save();

        Toastr::success("Shop Inserted Successfully","Success");
        return redirect()->back();

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
