<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Quote;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:quotes-list|quotes-create|quotes-edit', ['only' => ['index','store']]);
        $this->middleware('permission:quotes-create', ['only' => ['create','store']]);
        $this->middleware('permission:quotes-edit', ['only' => ['edit','update']]);

    }
    public function index()
    {
        $quotes = Quote::all();
        return view('backend.admin.quote.index',compact('quotes'));
    }

    public function create()
    {
        $quote = Quote::first();
        if (empty($quote))
        {
            return view('backend.admin.quote.create',compact('$quote'));
        }
        else
        {
            return view('backend.admin.quote.edit',compact('quote'));
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $new_quote = new Quote();
        $new_quote->title = $request->title;
        if($request->hasFile('image')){
            $new_quote->image = $request->image->store('uploads/quote/');
        }
        $new_quote->save();
        Toastr::success('Quote Created Successfully');
        return redirect()->route('admin.quote.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $quote = Quote::find($id);
        return view('backend.admin.quote.edit',compact('quote'));
    }

    public function update(Request $request, $id)
    {
        $quote = Quote::find($id);
        $quote->title = $request->title;
        if($request->hasFile('image')){
            $quote->image = $request->image->store('uploads/quote/');
        }
        $quote->save();
        Toastr::success('Quote Updated Successfully');
        return redirect()->route('admin.quote.index');
    }

    public function destroy($id)
    {
        $quote = Quote::find($id);
        $quote->delete();
        Toastr::success('Quote Deleted Successfully');
        return redirect()->route('admin.quote.index');
    }
}
