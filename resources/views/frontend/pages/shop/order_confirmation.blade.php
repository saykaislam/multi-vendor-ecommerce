@extends('frontend.layouts.master')
@section('title', 'Order Confirmation')
@section('content')
    <div class="ps-page--simple">
        <div class="ps-breadcrumb" style="background: #fff;">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Confirmation</li>
                </ul>
            </div>
        </div>
{{--        @dd($order->shop->shipping_time)--}}
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto" style="padding-bottom: 100px;">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center py-4 border-bottom mb-4">
                                <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                                <h1 class="h3 mb-3">Thank You for Your Order!</h1>
                                <h2 class="h5 strong-700">Invoice Code: {{$order->invoice_code}}</h2>
                                <h3 class="text-info">Your Order will be shipped within {{$order->shop->shipping_time}} </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
