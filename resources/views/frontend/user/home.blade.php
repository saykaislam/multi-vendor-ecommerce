@extends('frontend.layouts.master')
@section('title', 'User Dashboard')
@push('css')
    <style>
        .card_style{
            max-width: 24rem;
            color: white;
        }
        a:hover {
            color: #333;
        }
    </style>
@endpush
@section('content')
    <main class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>User Information</li>
                </ul>
                {{--                <div class="text-right">Logout</div>--}}
            </div>
        </div>
        <section class="ps-section--account">
            <div class="container">
                <div class="row">
                    @include('frontend.user.includes.user_sidebar')
                    <div class="col-lg-9">
                        <div class="ps-section__right">
                            <h3 style="margin-bottom: 30px;">Dashboard</h3>
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="card bg-success mb-4 card_style">
                                        <div class="card-body">
                                            <div class="text-center text-white py-4 mb-2" >
                                            <h3 class="card-title text-white mb-3">{{Auth::User()->balance}} Tk</h3>
                                                <p class="text-white"><a href="#">Balance</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card bg-danger mb-4 card_style">
                                        <div class="card-body">
                                            <div class="text-center text-white py-4 mb-2" >
                                                <h1 class="h3 text-white mb-3">{{\Gloudemans\Shoppingcart\Facades\Cart::count()}} Product(s)</h1>
                                                <p class="text-white"><a href="{{route('shopping-cart')}}">In your Cart</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card bg-warning mb-4 card_style">
                                        <div class="card-body">
                                            <div class="text-center text-white py-4 mb-2" >
                                                <h1 class="h3 text-white mb-3"> {{$totalWishlist}} Product(s)</h1>
                                                <p class="text-white"><a href="{{route('user.wishlist')}}">In Your Wishlist</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card bg-info mb-4 card_style">
                                        <div class="card-body">
                                            <div class="text-center text-white py-4 mb-2" >
                                                <h1 class="h3 text-white mb-3"> {{$totalOrder}} Order(s)</h1>
                                                <p class="text-white"><a href="{{route('user.order.history')}}">You ordered</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
