<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\Product;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FlashDealController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:flash_deals-list|flash_deals-create|flash_deals-edit', ['only' => ['index','store']]);
        $this->middleware('permission:flash_deals-create', ['only' => ['create','store']]);
        $this->middleware('permission:flash_deals-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:flash_deals-product-create', ['only' => ['productsAdd','flashDealProductsStore']]);
        $this->middleware('permission:flash_deals-product-edit', ['only' => ['productsEdit','flashDealProductsUpdate']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fashDeals = FlashDeal::where('user_type','admin')->latest()->get();
        return view('backend.admin.flash_deals.index', compact('fashDeals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('backend.admin.flash_deals.create');
    }
    public function productsAdd($flash_id)
    {
        $flashDeal = FlashDeal::find(decrypt($flash_id));
        return view('backend.admin.flash_deals.add_flush_deals_products', compact('flashDeal'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $flash_deal = new FlashDeal;
        $flash_deal->title = $request->title;
        $flash_deal->user_id = Auth::id();
        $flash_deal->user_type = 'admin';
        $flash_deal->status = 0;
        $flash_deal->start_date = strtotime($request->start_date);
        $flash_deal->end_date = strtotime($request->end_date);
        $flash_deal->slug =  Str::slug($request->title);
        if($flash_deal->save()){
            Toastr::success('Flash Deal has been created successfully, Please add Products');
            return redirect()->route('admin.flash_deals.products.add',encrypt($flash_deal->id));
        }
        else{
            Toastr::error('Something went wrong');
            return back();
        }
    }
    public function flashDealProductsStore(Request $request)
    {
        //dd($request->all());
        if ($request->shop == 'Please select one shop'){
             Toastr::warning('Please select shop first. After that select at least one product','Attention!!');
            return back();
        }
        foreach ($request->products as $key => $product) {
            $flash_deal_product = new FlashDealProduct;
            $flash_deal_product->flash_deal_id = $request->flash_deal_id;
            $flash_deal_product->product_id = $product;
            $flash_deal_product->user_id = $request->shop;
            $flash_deal_product->user_type = 'seller';
            $flash_deal_product->discount = $request['discount_'.$product];
            $flash_deal_product->discount_type = $request['discount_type_'.$product];
            $flash_deal_product->save();
        }
        Toastr::success('Flash Deal products has been inserted successfully');
        return back();
    }

    public function flashDealProductsUpdate(Request $request)
    {
        //dd($request->all());
        if ($request->shop == 'Please select one shop'){
            Toastr::warning('Please select shop first. After that select at least one product','Attention!!');
            return back();
        }
        FlashDealProduct::where('user_id',$request->shop)->delete();
        foreach ($request->products as $key => $product) {

                $flash_deal_product = new FlashDealProduct;
                $flash_deal_product->flash_deal_id = $request->flash_deal_id;
                $flash_deal_product->product_id = $product;
                $flash_deal_product->user_id = $request->shop;
                $flash_deal_product->user_type = 'seller';
                $flash_deal_product->discount = $request['discount_'.$product];
                $flash_deal_product->discount_type = $request['discount_type_'.$product];
                $flash_deal_product->save();

        }
        Toastr::success('Flash Deal products has been inserted successfully');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd('oops!! oh no!!');
        $flash_deal = FlashDeal::findOrFail(decrypt($id));
        return view('backend.admin.flash_deals.edit', compact('flash_deal'));
    }

    public function productsEdit($flash_id)
    {
        $flashDeal = FlashDeal::find(decrypt($flash_id));
        return view('backend.admin.flash_deals.edit_flush_deals_products', compact('flashDeal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($id);
        $flash_deal =  FlashDeal::find($id);
        $flash_deal->title = $request->title;
        $flash_deal->user_id = Auth::id();
        $flash_deal->user_type = 'admin';
        $flash_deal->start_date = strtotime($request->start_date);
        $flash_deal->end_date = strtotime($request->end_date);
        $flash_deal->slug =  Str::slug($request->title);
        if($flash_deal->save()){
            Toastr::success('Flash Deal has been created successfully, Please add Products');
            return back();
        }
        else{
            Toastr::error('Something went wrong');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function product_discount(Request $request){
        //return
        $product_ids = $request->product_ids;
        return view('backend.partials.flash_deal_discount', compact('product_ids'));
    }
    public function product_discount_edit(Request $request){
        $product_ids = $request->product_ids;
        $flash_deal_id = $request->flash_deal_id;
        return view('backend.partials.flash_deal_discount_edit', compact('product_ids', 'flash_deal_id'));
    }
    public function shopProducts($id)
    {
      $products = Product::where('user_id', $id)->where('published',1)->get();
      if (!empty($products)){
          return response()->json(['success'=>true,'response' => $products]);
      }else{
          return response()->json(['success'=>false,'response' => 'no products found!']);
      }
    }

    public function shopProductsEdit($id,$flash_id)
    {
        $products = Product::where('user_id', $id)->where('published',1)->get();
        if (!empty($products)){
            //dd($products);
            return view('backend.admin.flash_deals.selected_option_view',compact('products','flash_id'));
        }else{
            return response()->json(['success'=>false,'response' => 'no products found!']);
        }
    }


    public function update_status(Request $request)
    {
        $flash_deal = FlashDeal::findOrFail($request->id);
        $flash_deal->status = $request->status;
        if($flash_deal->save()){
            Toastr::success('Flash deal status updated successfully');
            return 1;
        }
        return 0;
    }

    public function update_featured(Request $request)
    {
        foreach (FlashDeal::where('user_type','admin')->get() as $key => $flash_deal) {
            $flash_deal->featured = 0;
            $flash_deal->save();
        }
        $flash_deal = FlashDeal::findOrFail($request->id);
        $flash_deal->featured = $request->featured;
        if($flash_deal->save()){
            Toastr::success('Flash deal status updated successfully');
            return 1;
        }
        return 0;
    }
}
