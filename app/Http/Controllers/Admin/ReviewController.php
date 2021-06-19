<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Review;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:review-list', ['only' => ['index','reviewDetails']]);
        $this->middleware('permission:review-show', ['only' => ['view','updateStatus']]);
        $this->middleware('permission:review-update', ['only' => ['reviewUpdate']]);


    }
    public function index() {
        $value = null;
        $reviews = null;
        return view('backend.admin.review.index',compact('value','reviews'));
    }
    public function reviewDetails(Request $request){
        $value = $request->rating;
        $reviews = Review::where('rating',$value)->get();
        return view('backend.admin.review.index',compact('value','reviews'));
    }

    public function updateStatus(Request $request){
        $review = Review::findOrFail($request->id);
        $review->status = $request->status;
        if($review->save()){
            return 1;
        }
        return 0;
    }
    public function view($id){
        $review = Review::find($id);
        if($review->viewed == 0){
            $review->viewed = 1;
            $review->save();
        }
        return view('backend.admin.review.show',compact('review'));
    }
    public function reviewUpdate(Request $request, $id) {
        $review = Review::find($id);
        $review->comment = $request->comment;
        $review->save();
        Toastr::success('Review Updated Successfully');
        return redirect()->route('admin.review.index');
    }
}
