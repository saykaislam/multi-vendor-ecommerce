@extends('frontend.layouts.master')
@section('title', 'Home')
@push('css')
    <style>

    </style>
@endpush
@section('content')
    <div id="homepage-1">

@include('frontend.includes.sliders')
        <div class="container ">
            <div class="city-list row shop_list">
                <div class="col-md-12 text-center my-5" id="loader">
                    <img  src="{{asset('frontend/img/shop/loader.gif')}}"  class="img-fluid ">
                </div>
            </div>
        </div>
        <div class="ps-home-ads" style="padding-top: 20px; padding-bottom: 20px; background-color: #f3f3f3">
            <div class="ps-container">
                <div class="row">
                    @foreach($offers as $offer)
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img src="{{url($offer->image)}}" alt=""></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="ps-home-ads" style="padding-top: 20px; padding-bottom: 20px;">
            <div class="ps-container">
                <div class="row">
                    <div class="col-md-6">
                      <img src="{{asset('frontend/img/list.jpg')}}" >
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-5" style="padding-top: 20px;">
                        @php
                        $total_seller = \App\User::where('user_type','seller')->count();
                        $total_customer = \App\User::where('user_type','customer')->count();
                        $total_order = \App\Model\Order::where('delivery_status','Completed')->count();
                        @endphp
                        <div class="card" style="background-color: #f3f3f3">
                            <div class="card-body" style="padding: 50px;">
                                <h3 ><span >Total Seller:</span> {{$total_seller + 200}}</h3>
                                <h3 ><span >Total Customer:</span> {{$total_customer + 500}}</h3>
                                <h3 ><span >Total Successful Order:</span> {{$total_order + 250}}</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

{{--        @if( !empty($flashDeal) && $flashDeal->featured == 1  && strtotime(date('d-m-Y')) >= $flashDeal->start_date && strtotime(date('d-m-Y')) <= $flashDeal->end_date)--}}
{{--        <div class="ps-deal-of-day" style="padding-top: 40px;">--}}
{{--            <div class="ps-container">--}}
{{--                <div class="ps-section__header">--}}
{{--                    <div class="ps-block--countdown-deal">--}}
{{--                        <div class="ps-block__left">--}}
{{--                            <h3>{{$flashDeal->title}}</h3>--}}
{{--                        </div>--}}
{{--                        <div class="ps-block__right">--}}
{{--                            <figure>--}}
{{--                                <figcaption>End in:</figcaption>--}}
{{--                                <ul class="ps-countdown" data-time="{{date('m/d/Y', $flashDeal->end_date)}}">--}}
{{--                                    <li><span class="days"></span></li>--}}
{{--                                    <li><span class="hours"></span></li>--}}
{{--                                    <li><span class="minutes"></span></li>--}}
{{--                                    <li><span class="seconds"></span></li>--}}
{{--                                </ul>--}}
{{--                            </figure>--}}
{{--                        </div>--}}
{{--                    </div><a href="{{route('flash-deals',$flashDeal->slug)}}">View all</a>--}}
{{--                </div>--}}
{{--                <div class="ps-section__content">--}}
{{--                    <div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="7" data-owl-item-xs="2" data-owl-item-sm="3" data-owl-item-md="4" data-owl-item-lg="5" data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">--}}

{{--                        @foreach($flashDealProducts as $flashDealProduct)--}}
{{--                        <div class="ps-product ps-product--inner">--}}
{{--                            <div class="ps-product__thumbnail"><a href="{{route('product-details',$flashDealProduct->product->slug)}}"><img src="{{asset($flashDealProduct->product->thumbnail_img)}}" alt="" width="153" height="171"></a>--}}
{{--                                <ul class="ps-product__actions">--}}
{{--                                    <li><a href="{{route('product-details',$flashDealProduct->product->slug)}}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
{{--                                    <li><a href="{{route('product-details',$flashDealProduct->product->slug)}}" data-placement="top" title="Show Details" data-toggle="tooltip" ><i class="icon-eye"></i></a></li>--}}
{{--                                    <li><a href="{{route('add.wishlist',$flashDealProduct->product->id)}}" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <div class="ps-product__container">--}}
{{--                                <p class="ps-product__price sale">৳{{home_discounted_base_price($flashDealProduct->product_id)}}--}}
{{--                                    @if(home_base_price($flashDealProduct->product_id) != home_discounted_base_price($flashDealProduct->product_id))--}}
{{--                                        <del>৳{{home_base_price($flashDealProduct->product_id)}}</del>--}}
{{--                                    @else--}}
{{--                                        ৳{{home_discounted_base_price($flashDealProduct->product_id)}}--}}
{{--                                    @endif</p>--}}
{{--                                <div class="ps-product__content"><a class="ps-product__title" href="{{route('product-details',$flashDealProduct->product->slug)}}">{{$flashDealProduct->product->name}}</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        @endif--}}

{{--        <div class="ps-product-list ps-new-arrivals" style="padding-bottom: 20px;">--}}
{{--            <div class="ps-container">--}}
{{--                <div class="ps-section__header">--}}
{{--                    <h3>Best Selling Product</h3>--}}
{{--                    <ul class="ps-section__links">--}}
{{--                        @foreach($categories as $cat)--}}
{{--                            <li><a href="shop-grid.html">{{$cat->name}}</a></li>--}}
{{--                        @endforeach--}}
{{--                        <li><a href="#">Top 20</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="ps-section__content">--}}
{{--                    <div class="row">--}}
{{--                        @foreach($best_sales_products as $product)--}}
{{--                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 ">--}}
{{--                                <div class="ps-product--horizontal">--}}
{{--                                    <div class="ps-product__thumbnail"><a href="{{route('product-details',$product->slug)}}"><img src="{{url($product->thumbnail_img)}}" alt=""></a></div>--}}
{{--                                    <div class="ps-product__content"><a class="ps-product__title" href="{{route('product-details',$product->slug)}}">{{ $product->name }}</a>--}}
{{--                                        <p class="ps-product__price">৳{{$product->unit_price}}</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="ps-product-list ps-new-arrivals" style="padding-bottom: 20px;">--}}
{{--            <div class="ps-container">--}}
{{--                <div class="ps-section__header">--}}
{{--                    <h3>Best Sellers</h3>--}}
{{--                    <ul class="ps-section__links">--}}
{{--                        <li><a href="{{route('best-seller.shop-list')}}">View All</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="ps-section__content">--}}
{{--                    <div class="row">--}}
{{--                        @foreach($orders as $order)--}}
{{--                            @php--}}
{{--                                $shop = \App\Model\Shop::where('id',$order->shop_id)->first();--}}
{{--                            @endphp--}}
{{--                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 ">--}}
{{--                                    <div class="ps-product--horizontal">--}}
{{--                                        <div class="ps-product__thumbnail"><a href="{{route('shop.details',$shop->slug)}}"><img src="{{url($shop->logo)}}" alt="" width="100" height="75"></a></div>--}}
{{--                                        <div class="ps-product__content"><a class="ps-product__title" href="{{route('shop.details',$shop->slug)}}">{{ $shop->name }}</a>--}}

{{--                                            <div class="">--}}
{{--                                                <p class="ps-product__price"> <a href="{{route('shop.details',$shop->slug)}}">Visit Store</a>--}}
{{--                                                    <i class="right fa fa-angle-left"></i> </p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="ps-download-app" style="margin-top: -10px;">
            <div class="ps-container">
                <div class="ps-block--download-app">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                                <div class="ps-block__thumbnail"><img src="{{asset('frontend/img/application.png')}}" alt=""></div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                                <div class="ps-block__content">
                                    <h3>Download Mudi Hat App Now!</h3>
                                    <p>Shopping fastly and easily more with our app. Get a link to download the app on your phone</p>
                                    <form class="ps-form--download-app" action="/" method="post">
                                        {{--                                        <div class="form-group--nest">--}}
                                        {{--                                            <input class="form-control" type="Email" placeholder="Email Address">--}}
                                        {{--                                            <button class="ps-btn">Subscribe</button>--}}
                                        {{--                                        </div>--}}
                                    </form>
                                    <p class="download-link"><a href="https://play.google.com/store/apps/details?id=com.starit.mudihat"><img src="{{asset('frontend/img/google-play.png')}}" alt=""></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('frontend/js/location/home_location.js')}}"></script>
    <script src="{{asset('frontend/js/bk.cdn.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#loader').hide();
        })
    </script>
@endpush
