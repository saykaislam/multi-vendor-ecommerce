@extends('backend.layouts.master')
@section("title","Edit Sliders")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sliders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Sliders</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
                <!-- general form elements -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Edit Sliders</h3>
                        <div class="float-right">
                            <a href="{{route('admin.sliders.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>



                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.sliders.update',$slider->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <img src="{{asset('uploads/sliders/'.$slider->image)}}" width="80" height="50" alt="">
                            <div class="form-group">
                                <label for="image">Slider Image <small>(size: 1650 * 399 pixel)</small></label>
                                <input type="file" class="form-control" name="image" id="image" >
                            </div>
                            <div class="form-group">
                                <label for="url">Url</label>
                                <input type="url" class="form-control " name="url" id="url"
                                       value="{{$slider->url}}">
                            </div>
                            {{--                            <div class="form-group">--}}
                            {{--                                <label for="phone">Meta Title</label>--}}
                            {{--                                <input type="text" class="form-control" name="meta_title" id="phone" placeholder="Enter meta title">--}}
                            {{--                            </div>--}}
                            {{--                            <div class="form-group">--}}
                            {{--                                <label for="meta_desc">Meta Description</label>--}}
                            {{--                                <textarea name="meta_description" id="meta_desc" class="form-control"  rows="3"></textarea>--}}
                            {{--                            </div>--}}
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')

@endpush
