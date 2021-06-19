<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Seller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerInfoController extends Controller
{
    public function index()
    {
        $sellerInfo = Seller::where('user_id',Auth::User()->id)->first();
        return view('backend.seller.settings.seller_info.index',compact('sellerInfo'));
    }
    public function create()
    {
        return view('backend.seller.settings.seller_info.create');
    }

    public function store(Request $request)
    {
        $sellerInfo = Seller::where('user_id',Auth::User()->id)->first();
            $sellerInfo->nid_number = $request->nid_number;
            $tl = array();
            if($request->hasFile('trade_licence_images')){
                foreach ($request->trade_licence_images as $key => $trade_licence_image) {
                    $path = $trade_licence_image->store('uploads/seller_info');
                    array_push($tl, $path);
                    //ImageOptimizer::optimize(base_path('public/').$path);
                }
                $sellerInfo->trade_licence_images = json_encode($tl);
            }
            $sellerInfo->save();
            Toastr::success("Seller Info Updated Successfully","Success");
            return redirect()->route('seller.seller-info.index');
    }

    public function show($id)
    {
       //
    }

    public function edit($id)
    {
        $sellerInfo = Seller::find($id);
        return view('backend.seller.settings.seller_info.edit',compact('sellerInfo'));
    }

    public function update(Request $request, $id)
    {
        $sellerInfo = Seller::find($id);
        $sellerInfo->nid_number = $request->nid_number;
        if($request->has('previous_photos')){
            $photos = $request->previous_photos;
        }
        else{
            $photos = array();
        }

        if($request->hasFile('trade_licence_images')){
            foreach ($request->trade_licence_images as $key => $photo) {
                $path = $photo->store('uploads/seller_info');
                array_push($photos, $path);
                //ImageOptimizer::optimize(base_path('public/').$path);
            }
        }
        $sellerInfo->trade_licence_images = json_encode($photos);
        $sellerInfo->save();
        Toastr::success("Seller Info Updated Successfully","Success");
        return redirect()->route('seller.profile.show');
    }

    public function destroy($id)
    {
        //
    }
}
