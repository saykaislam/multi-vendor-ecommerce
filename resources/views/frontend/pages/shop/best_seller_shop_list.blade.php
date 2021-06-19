@extends('frontend.layouts.master')
@section('title', 'Best Seller Shops')
@push('css')
@endpush
@section('content')
    <div class="ps-page--single ps-page--vendor">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Best Seller Shops</li>
                </ul>
            </div>
        </div>
        <div class="ps-top-categories" style="padding-top: 20px;">
            <div class="ps-container">
                <h3 class="text-center">Best Seller Shops</h3>
                <div class="row">
                    @foreach($orders as $order)
                        @php
                            $shop = \App\Model\Shop::where('id',$order->shop_id)->first();
                        @endphp
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
