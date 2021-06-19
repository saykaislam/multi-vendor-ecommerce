<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Blog;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blog-list', ['only' => ['index','store']]);
        $this->middleware('permission:blog-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);

    }
    public function index()
    {
        $blogs = Blog::all();
        return view('backend.admin.blog.index',compact('blogs'));
    }

    public function create()
    {
        return view('backend.admin.blog.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'=> 'required',
            'description'=> 'required',
            'image'=> 'required',
        ]);
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->author = $request->author;
        $blog->description = $request->	description;
        $blog->short_description = strip_tags($request->description);
        if($request->hasFile('image')){
            $blog->image = $request->image->store('uploads/blogs/');
        }
        $blog->save();
        Toastr::success('Blog Created Successfully', 'Success');
        return redirect()->route('admin.blogs.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('backend.admin.blog.edit',compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'=> 'required',
            'description'=> 'required',

        ]);
        $blog = Blog::find($id);
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->author = $request->author;
        $blog->description = $request->	description;
        $blog->short_description = strip_tags($request->description);
        if($request->hasFile('image')){
            $blog->image = $request->image->store('uploads/blogs/');
        }
        $blog->save();
        Toastr::success('Blog Updated Successfully', 'Success');
        return redirect()->route('admin.blogs.index');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        if(Storage::disk('public')->exists('uploads/offers/'.$blog->image))
        {
            Storage::disk('public')->delete('uploads/offers/'.$blog->image);
        }
        $blog->delete();
        Toastr::success('Blog Deleted Successfully!');
        return redirect()->route('admin.blogs.index');
    }
}
