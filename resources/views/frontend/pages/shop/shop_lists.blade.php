@extends('frontend.layouts.master')
@section('title', 'Shops')
@push('css')
@endpush
@section('content')
    <div class="ps-page--single ps-page--vendor">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Shop List</li>
                </ul>
            </div>
        </div>
        <div class="ps-top-categories" style="padding-top: 20px;">
            <div class="ps-container">
                <h3 class="text-center">All Shop Lists</h3>
                <div class="row">
                    @foreach($shops as $shop)
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 ">
                            <div class="ps-block--category"><a class="ps-block__overlay" href="{{route('shop.details',$shop->slug)}}"></a><img src="{{url($shop->logo)}}" alt="" width="148" height="148">
                                <p>{{$shop->name}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
@endpush
