@extends('backend.layouts.master')
@section("title","Edit Offer")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Offer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Offer</li>
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
                        <h3 class="card-title float-left">Edit Offer</h3>
                        <div class="float-right">
                            <a href="{{route('admin.offers.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>



                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.offers.update',$offer->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="{{$offer->title}}" required>
                            </div>
                            <img src="{{url($offer->image)}}" width="80" height="50" alt="">
                            <div class="form-group">
                                <label for="image">Offer Image</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="promo_code">Promo Code</label>--}}
{{--                                <input type="text" class="form-control" name="promo_code" id="promo_code" placeholder="Enter Promo Code" value="{{$offer->promo_code}}" required>--}}
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
