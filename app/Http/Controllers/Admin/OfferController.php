<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Offer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OfferController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:offers-list|offers-create|offers-edit', ['only' => ['index','store']]);
        $this->middleware('permission:offers-create', ['only' => ['create','store']]);
        $this->middleware('permission:offers-edit', ['only' => ['edit','update']]);

    }
    public function index()
    {
        $offers = Offer::all();
        return view('backend.admin.offers.index',compact('offers'));

    }

    public function create()
    {
        return view('backend.admin.offers.create');
    }

    public function store(Request $request)
    {
//        $this->validate($request, [
//            'title'=> 'required',
//        ]);

        $offer = new Offer();
        $offer->title = $request->title;
        if($request->hasFile('image')){
            $offer->image = $request->image->store('uploads/offers/');
        }
        $offer->promo_code = $request->promo_code;
        $offer->save();
        Toastr::success('Offer Created Successfully');
        return redirect()->route('admin.offers.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $offer = Offer::find($id);
        return view('backend.admin.offers.edit',compact('offer'));

    }

    public function update(Request $request, $id)
    {
        $offer =  Offer::find($id);
        $offer->title = $request->title;
        if($request->hasFile('image')){
            $offer->image = $request->image->store('uploads/offers/');
        }
        $offer->promo_code = $request->promo_code;
        $offer->save();
        Toastr::success('Offer Updated Successfully');
        return redirect()->route('admin.offers.index');
    }

    public function destroy($id)
    {
        $offer = Offer::find($id);
        if(Storage::disk('public')->exists('uploads/offers/'.$offer->image))
        {
            Storage::disk('public')->delete('uploads/offers/'.$offer->image);
        }
        $offer->delete();
        Toastr::success('Offer Deleted Successfully');
        return back();
    }
}
