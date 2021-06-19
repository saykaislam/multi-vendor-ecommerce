<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Attribute;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:attribute-list|attribute-create|attribute-edit', ['only' => ['index','store']]);
        $this->middleware('permission:attribute-create', ['only' => ['create','store']]);
        $this->middleware('permission:attribute-edit', ['only' => ['edit','update']]);

    }
    public function index()
    {
        $attributes = Attribute::all();
        return view('backend.admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|unique:attributes,name',
        ]);

        $attibute = new Attribute();
        $attibute->name = $request->name;
        $attibute->save();
        Toastr::success('Attribute Added Successfully Done!!');
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
        $attribute = Attribute::find($id);
        return view('backend.admin.attributes.edit', compact('attribute'));
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
        $this->validate($request, [
            'name'=> 'required|unique:attributes,name,'.$id,
        ]);

        $attibute = Attribute::find($id);
        $attibute->name = $request->name;
        $attibute->save();
        Toastr::success('Attribute Updated Successfully Done!!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Attribute::find($id)->delete();
        Toastr::success('Attribute Deleted Successfully Done!!');
        return back();
    }
}
