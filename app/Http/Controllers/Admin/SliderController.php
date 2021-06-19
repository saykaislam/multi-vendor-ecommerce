<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Slider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sliders-list|sliders-create|sliders-edit', ['only' => ['index','store']]);
        $this->middleware('permission:sliders-create', ['only' => ['create','store']]);
        $this->middleware('permission:sliders-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sliders-delete', ['only' => ['destroy']]);

    }
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('backend.admin.sliders.index',compact('sliders'));
    }

    public function create()
    {
        return view('backend.admin.sliders.create');
    }

    public function store(Request $request)
    {
//        $this->validate($request, [
//            'name'=> 'required|unique:categories,name',
//        ]);

        $slider = new Slider();
        $image = $request->file('image');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(1650, 399)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/sliders/' . $imagename, $proImage);

        }else {
            $imagename = "default.png";
        }
        $slider->image = $imagename;
        $slider->url = $request->url;
        $slider->save();
        Toastr::success('Slider Created Successfully');
        return redirect()->route('admin.sliders.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('backend.admin.sliders.edit',compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider =  Slider::find($id);
        $image = $request->file('image');
        if (isset($image)) {
            //make unique name for image
            if(Storage::disk('public')->exists('uploads/sliders/'.$slider->icon))
            {
                Storage::disk('public')->delete('uploads/sliders/'.$slider->icon);
            }
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for slider and upload
            $proImage = Image::make($image)->resize(1650, 399)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/sliders/' . $imagename, $proImage);

        }else {
            $imagename = $slider->image;
        }
        $slider->image = $imagename;
        $slider->url = $request->url;
        $slider->save();
        Toastr::success('Slider Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);
        if(Storage::disk('public')->exists('uploads/sliders/'.$slider->image))
        {
            Storage::disk('public')->delete('uploads/sliders/'.$slider->image);
        }
        $slider->delete();
        Toastr::success('Sliders Deleted Successfully');
        return back();

    }
}
