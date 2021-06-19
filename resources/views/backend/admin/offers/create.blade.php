@extends('backend.layouts.master')
@section("title","Add Offers")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Offers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add Offers</li>
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
                        <h3 class="card-title float-left">Add Offers</h3>
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
                    <form role="form" action="{{route('admin.offers.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Offer Image</label>
                                <input type="file" class="form-control" name="image" id="image" >
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="promo_code">Promo Code</label>--}}
{{--                                <input type="text" class="form-control" name="promo_code" id="promo_code" placeholder="Enter Promo Code" required>--}}
{{--                            </div>--}}
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
