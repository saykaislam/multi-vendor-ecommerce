<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetails;
use App\Model\Product;
use App\Model\Review;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('frontend.user.order_history',compact('orders'));
    }
    public function orderDetails($id){
        $order = Order::find(decrypt($id));
        $orderDetails = OrderDetails::where('order_id',$order->id)->get();
        return view('frontend.user.order_details',compact('order','orderDetails'));

    }

    public function printInvoice($id) {
        $order = Order::find(decrypt($id));
        return view('frontend.user.invoice_print',compact('order'));
    }
    public function reviewStore(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $shop = Shop::where('user_id', $product->user_id)->first();

        $review = new Review;
        $review->order_id = $request->order_id;
        $review->product_id = $request->product_id;
        $review->user_id = Auth::user()->id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->shop_id = $shop->id;
        $review->viewed = '0';
        if($review->save()){
            if(count(Review::where('product_id', $product->id)->where('status', 1)->get()) > 0){
                $product->rating = Review::where('product_id', $product->id)
                        ->where('status', 1)->sum('rating')/count(Review::where('product_id', $product->id)->where('status', 1)->get());
            }
            else {
                $product->rating = 0;
            }
            $product->save();
            Toastr::success('Review has been submitted successfully');
            return back();
        }
        Toastr::error('Something went wrong!');
        return back();
    }

}
