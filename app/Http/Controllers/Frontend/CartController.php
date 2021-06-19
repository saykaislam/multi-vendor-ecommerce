<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Address;
use App\Model\BusinessSetting;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\Order;
use App\Model\OrderDetails;
use App\Model\OrderTempCommission;
use App\Model\Product;
use App\Model\ProductStock;
use App\Model\Seller;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function viewCart() {
        return view('frontend.pages.shop.shopping_cart');
    }




    public function ProductAddCart(Request  $request) {
        //dd('add to cart');
        $var=$request->variant;
        $product=Product::find($request->product_id);
        if(Cart::count()!=0){
            foreach (Cart::content() as $item){
                if($product->user_id!=$item->options->shop_userid){
                    Cart::destroy();
                    break;
                }
            }
        }
        $flashSales =  $flashSales = FlashDealProduct::where('product_id',$product->id)->first();
        //dd($flashSales->count());
        $shop=\App\Model\Shop::where('user_id',$product->user_id)->first();
        if($product->variant_product==null && $product->discount == 0 ){
            //dd("no");
            if (!empty($flashSales)){
                $qty=$var[count($var)-1]['value'];
                $data = array();
                $data['id'] = $product->id;
                $data['name'] = $product->name;
                $data['qty'] = $qty;
                $data['price'] = home_discounted_base_price($product->id);
                $data['options']['image'] = $product->thumbnail_img;
                $data['options']['shipping_cost'] = 60;
                $data['options']['variant_id'] = null;
                $data['options']['variant'] = null;
                $data['options']['shop_name'] =  $shop->name;
                $data['options']['shop_id'] =  $shop->id;
                $data['options']['shop_userid'] =  $product->user_id;
                $data['options']['cart_type'] = "product";
                $data['options']['labour_cost'] = $product->labour_cost;
                $Price = home_discounted_base_price($product->id);
                $vPrice = 0;
                if ($product->vat_type == 'percent') {
                    $data['options']['vat_type'] = 'percent';
                    $vPrice += ($Price * $product->vat) / 100;
                } elseif ($product->vat_type == 'amount') {
                    $data['options']['vat_type'] = 'amount';
                    $vPrice += $product->vat;
                }
                $data['options']['vat'] = $vPrice;
                Cart::add($data);
                $data['countCart'] = Cart::count();
                //dd(Cart::content());
                return response()->json(['success'=> true, 'response'=>$data]);
            }

            $qty=$var[count($var)-1]['value'];
            $data = array();
            $data['id'] = $product->id;
            $data['name'] = $product->name;
            $data['qty'] = $qty;
            $data['price'] = $product->unit_price;
            $data['options']['image'] = $product->thumbnail_img;
            $data['options']['shipping_cost'] = 60;
            $data['options']['variant_id'] = null;
            $data['options']['variant'] = null;
            $data['options']['shop_name'] =  $shop->name;
            $data['options']['shop_id'] =  $shop->id;
            $data['options']['shop_userid'] =  $product->user_id;
            $data['options']['cart_type'] = "product";
            $data['options']['labour_cost'] = $product->labour_cost;
            $Price = $product->unit_price;
            $vPrice = 0;
            if ($product->vat_type == 'percent') {
                $data['options']['vat_type'] = 'percent';
                $vPrice += ($Price * $product->vat) / 100;
            } elseif ($product->vat_type == 'amount') {
                $data['options']['vat_type'] = 'amount';
                $vPrice += $product->vat;
            }
            $data['options']['vat'] = $vPrice;

            Cart::add($data);
            $data['countCart'] = Cart::count();
            //dd(Cart::content());
//            dd("not flash sales");
            return response()->json(['success'=> true, 'response'=>$data]);
        }elseif(!empty($flashSales)){
            //dd("flash sales");
            $qty=$var[count($var)-1]['value'];
            $data = array();
            $data['id'] = $product->id;
            $data['name'] = $product->name;
            $data['qty'] = $qty;
            $data['price'] = home_discounted_base_price($product->id);
            $data['options']['image'] = $product->thumbnail_img;
            $data['options']['shipping_cost'] = 60;
            $data['options']['variant_id'] = null;
            $data['options']['variant'] = null;
            $data['options']['shop_name'] =  $shop->name;
            $data['options']['shop_id'] =  $shop->id;
            $data['options']['shop_userid'] =  $product->user_id;
            $data['options']['cart_type'] = "product";
            $data['options']['labour_cost'] = $product->labour_cost;
            $Price = home_discounted_base_price($product->id);
            $vPrice = 0;
            if ($product->vat_type == 'percent') {
                $data['options']['vat_type'] = 'percent';
                $vPrice += ($Price * $product->vat) / 100;
            } elseif ($product->vat_type == 'amount') {
                $data['options']['vat_type'] = 'amount';
                $vPrice += $product->vat;
            }
            $data['options']['vat'] = $vPrice;

            Cart::add($data);
            $data['countCart'] = Cart::count();
            //dd(Cart::content());
            return response()->json(['success'=> true, 'response'=>$data]);
        }else{
            if ($product->discount > 0){
                $c=count($request->variant);
                $i=1;
                $v=[];
                for($i=1;$i<$c-1;$i++){
                    array_push($v,$var[$i]['value']);
                }
                $implode=implode("-", $v);
                $variant=ProductStock::where('variant',$implode)->first();
                $qty=$var[count($var)-1]['value'];
                $data = array();
                $data['id'] = $product->id;
                $data['name'] = $product->name;
                $data['qty'] = $qty;
                $data['price'] = variantProductPrice($variant->id);
                $data['options']['image'] = $product->thumbnail_img;
                $data['options']['shipping_cost'] = 60;
                $data['options']['variant_id'] = $variant->id;
                $data['options']['variant'] = $variant->variant;
                $data['options']['shop_name'] =  $shop->name;
                $data['options']['shop_id'] =  $shop->id;
                $data['options']['shop_userid'] =  $product->user_id;
                $data['options']['cart_type'] = "product";
                $data['options']['labour_cost'] = $product->labour_cost;
                $Price = variantProductPrice($product->id);
                $vPrice = 0;
                if ($product->vat_type == 'percent') {
                    $data['options']['vat_type'] = 'percent';
                    $vPrice += ($Price * $product->vat) / 100;
                } elseif ($product->vat_type == 'amount') {
                    $data['options']['vat_type'] = 'amount';
                    $vPrice += $product->vat;
                }
                $data['options']['vat'] = $vPrice;
                Cart::add($data);
                $data['countCart'] = Cart::count();
                $data['subtotal'] = Cart::subtotal();
//            $data['rowid'] = Cart::rowId;
                //dd(Cart::content());
                return response()->json(['success'=> true, 'response'=>$data]);
            }else{
                $c=count($request->variant);
                $i=1;
                $v=[];
                for($i=1;$i<$c-1;$i++){
                    array_push($v,$var[$i]['value']);
                }
                $implode=implode("-", $v);
                $variant=ProductStock::where('variant',$implode)->first();
                $qty=$var[count($var)-1]['value'];
                $data = array();
                $data['id'] = $product->id;
                $data['name'] = $product->name;
                $data['qty'] = $qty;
                $data['price'] = $variant->price;
                $data['options']['image'] = $product->thumbnail_img;
                $data['options']['shipping_cost'] = 60;
                $data['options']['variant_id'] = $variant->id;
                $data['options']['variant'] = $variant->variant;
                $data['options']['shop_name'] =  $shop->name;
                $data['options']['shop_id'] =  $shop->id;
                $data['options']['shop_userid'] =  $product->user_id;
                $data['options']['cart_type'] = "product";
                $data['options']['labour_cost'] = $product->labour_cost;
                $Price = $variant->price;
                $vPrice = 0;
                if ($product->vat_type == 'percent') {
                    $data['options']['vat_type'] = 'percent';
                    $vPrice += ($Price * $product->vat) / 100;
                } elseif ($product->vat_type == 'amount') {
                    $data['options']['vat_type'] = 'amount';
                    $vPrice += $product->vat;
                }
                $data['options']['vat'] = $vPrice;
                Cart::add($data);
                $data['countCart'] = Cart::count();
                $data['subtotal'] = Cart::subtotal();
//            $data['rowid'] = Cart::rowId;
                //dd(Cart::content());
                return response()->json(['success'=> true, 'response'=>$data]);
            }

        }

    }
    public function quantityUpdate(Request $request)
    {
        //dd($request->rid);
        $cartData = Cart::get($request->rid);
        $qty = $request->quantity;
        Toastr::success('Quantity Updated');
        Cart::update($request->rid, $qty);
        return back();
    }
    public function cartRemove($rowId)
    {
        Toastr::error('This Product removed from cart ');
        Cart::remove($rowId);
        return back();
    }
    public function clearCart()
    {
        Cart::destroy();
        return back();
    }

    public function checkout() {
        if(Cart::count()==0){
            Toastr::error('Nothing fount in cart');
            return back();
        }
        $addresses = Address::where('user_id', Auth::id())->get();
//        dd($address);
        return view('frontend.pages.shop.checkout',compact('addresses'));
    }

    public function orderSubmit(Request $request) {
        if ($request->address_id == null) {
            Toastr::error('Please select an address.','Please Select');
            return back();
        }
        //dd($request->all());
        $this->validate($request,[
//            'name' => 'required',
//            'address' => 'required',
//            'phone' => 'required',
            'pay' => 'required',
        ]);
        if($request->pay == 'cod'){
            $payment_status = 'Due';
        }
        if($request->pay == 'ssl'){
            $payment_status = 'Paid';
        }
        $address = Address::where('user_id',Auth::id())->where('id',$request->address_id)->first();
        $data['name'] = $request->name;
        $data['email'] = Auth::User()->email;
        $data['address'] = $address->address;
        $data['country'] = $address->country;
        $data['city'] = $address->city;
        $data['postal_code'] = $address->postal_code;
        $data['phone'] = $address->phone;
        $shipping_info = json_encode($data);

        foreach (Cart::content() as $content) {
           $shop_id = $content->options->shop_id;
           break;
        }
        $check = Order::where('user_id',Auth::id())->first();
        $discount = BusinessSetting::where('type','first_order_discount')->first();
        $order = new Order();
        $order->invoice_code = date('Ymd-his');
        $order->user_id = Auth::user()->id;
        $order->shop_id = $shop_id;
        $order->area = $address->area;
        $order->latitude = $address->latitude;
        $order->longitude = $address->longitude;
        $order->shipping_address = $shipping_info;
        $order->payment_type = $request->pay;
        $order->payment_status = $payment_status;
        $order->grand_total = Cart::total();
        if (empty($check)) {
            $order->discount = $discount->value;
            $order->grand_total = Cart::total() - $order->discount;
        }
        $order->delivery_cost = 0;
        $order->delivery_status = "Pending";
        $order->view = 0;
        $order->type = "product";
        $order->save();

        $profit = 0;
        $totalVat = 0;
        $totalLabourCost = 0;
        foreach (Cart::content() as $content) {
            //dd($content->options->labour_cost);
            $product = Product::find($content->id);

            $orderDetails = new OrderDetails();
            $orderDetails->order_id = $order->id;
            $orderDetails->variation_id = $content->options->variant_id;
            $orderDetails->product_id = $content->id;
            $orderDetails->name = $content->name;
            $orderDetails->price = $content->price;
            $orderDetails->quantity = $content->qty;
            $vPrice = 0;
            if ($product->vat_type == 'percent') {
                $vPrice += ($content->price * $product->vat) / 100;
            } elseif ($product->vat_type == 'amount') {
                $vPrice += $product->vat;
            }
            $orderDetails->vat = $vPrice;
            $orderDetails->labour_cost = $content->options->labour_cost;
            $totalVat += $vPrice*$content->qty;
            $totalLabourCost += ($content->options->labour_cost)*$content->qty;
            $orderDetails->save();

            $product->num_of_sale++;
            $product->save();
            $profitData = ($content->price - $product->purchase_price) * $content->qty;
            $profit += $profitData;
        }
        $orderUpdate = Order::find($order->id);
        $orderUpdate->profit = $profit;
        $orderUpdate->total_vat = $totalVat;
        $orderUpdate->total_labour_cost = $totalLabourCost;
        $orderUpdate->grand_total += $totalVat +$totalLabourCost;
        $orderUpdate->save();

        if ($request->pay == 'cod') {
            $getShopId = Shop::find($shop_id);
            $getSellerData = Seller::where('user_id',$getShopId->user_id)->first();
            //dd($getSellerData);
            $grandTotal = Cart::total();
            //dd($grandTotal);
            $adminCommission = new OrderTempCommission();
            $adminCommission->order_id = $order->id;
            $adminCommission->shop_id = $shop_id;
            $adminCommission->temp_commission_to_seller = 0;
            $adminCommission->temp_commission_to_admin = $grandTotal*$getSellerData->commission / 100;
            $adminCommission->save();

            Toastr::success('Order Successfully done! ');
            Cart::destroy();
            return view('frontend.pages.shop.order_confirmation',compact('order'));
        }else {
//            Session::put('order_id',$order->id);
//            return redirect()->route('pay');
            /*Toastr::success('Order Successfully done! ');
            Cart::destroy();*/
            Toastr::warning('Online Payment Method not yet done. Please try on COD');
            return redirect()->back();
        }
        return view('frontend.pages.shop.checkout');
    }
}
