@extends('frontend.layouts.master')
@section('title','Flash Deal Products')
@section('content')
    <div class="ps-breadcrumb">
        <div class="ps-container">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li>{{$flashDeal->title}}</li>
            </ul>
        </div>
    </div>
    <div class="ps-page--product">
        <div class="ps-container">
            <div class="ps-page__container">
                    <div class="ps-product--detail ps-product--fullwidth" style="margin-bottom: -5rem;">
                                <div class="ps-product__countdown">
                                    <figure>
{{--                                        <figcaption class="text-center"> {{$flashDeal->title}}</figcaption>--}}
                                        <h3 class="text-center">{{$flashDeal->title}}</h3>
                                        <ul class="ps-countdown text-center" data-time="{{date('m/d/Y', $flashDeal->end_date)}}">
                                            <li><span class="days"></span>
                                                <p>Days</p>
                                            </li>
                                            <li><span class="hours"></span>
                                                <p>Hours</p>
                                            </li>
                                            <li><span class="minutes"></span>
                                                <p>Minutes</p>
                                            </li>
                                            <li><span class="seconds"></span>
                                                <p>Seconds</p>
                                            </li>
                                        </ul>
                                    </figure>
{{--                                    <figure>--}}
{{--                                        <figcaption>Sold Items</figcaption>--}}
{{--                                        <div class="ps-product__progress-bar ps-progress" data-value="8">--}}
{{--                                            <div class="ps-progress__value"><span></span></div>--}}
{{--                                            <p><b>20/85</b> Sold</p>--}}
{{--                                        </div>--}}
{{--                                    </figure>--}}
                                </div>

                    </div>
            </div>
            <div class="ps-section--default ps-customer-bought">
                <div class="ps-section__content">
                    <div class="row">
                        @foreach($flashDealProducts as $flashDealProduct)
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6 ">
                            <div class="ps-product">
                                <div class="ps-product__thumbnail"><a href="{{route('product-details',$flashDealProduct->product->slug)}}"><img src="{{asset($flashDealProduct->product->thumbnail_img)}}" alt="" width="175" height="200"></a>
                                    {{--                                                        <div class="ps-product__badge">11%</div>--}}
                                    <ul class="ps-product__actions">
                                        <li><a href="{{route('product-details',$flashDealProduct->product->slug)}}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                        <li><a href="{{route('product-details',$flashDealProduct->product->slug)}}" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
                                        <li><a href="{{route('add.wishlist',$flashDealProduct->id)}}" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="ps-product__container"><a class="ps-product__vendor" href="{{route('product-details',$flashDealProduct->product->slug)}}"></a>
                                    <div class="ps-product__content"><a class="ps-product__title" href="">{{$flashDealProduct->product->name}}</a>
{{--                                        <div class="ps-product__rating">--}}
{{--                                            <select class="ps-rating" data-read-only="true">--}}
{{--                                                <option value="1">1</option>--}}
{{--                                                <option value="1">2</option>--}}
{{--                                                <option value="1">3</option>--}}
{{--                                                <option value="1">4</option>--}}
{{--                                                <option value="2">5</option>--}}
{{--                                            </select><span>01</span>--}}
{{--                                        </div>--}}
                                        <p class="ps-product__price sale">
                                            ৳{{home_discounted_base_price($flashDealProduct->product_id)}}
                                            @if(home_base_price($flashDealProduct->product_id) != home_discounted_base_price($flashDealProduct->product_id))
                                                <del>৳{{home_base_price($flashDealProduct->product_id)}}</del>
                                            @else
                                                ৳{{home_discounted_base_price($flashDealProduct->product_id)}}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="ps-product__content hover"><a class="ps-product__title" href="{{route('product-details',$flashDealProduct->product->slug)}}">{{$flashDealProduct->product->name}}</a>
                                        <p class="ps-product__price sale">
                                            ৳{{home_discounted_base_price($flashDealProduct->product_id)}}
                                            @if(home_base_price($flashDealProduct->product_id) != home_discounted_base_price($flashDealProduct->product_id))
                                                <del>৳{{home_base_price($flashDealProduct->product_id)}}</del>
                                            @else
                                                ৳{{home_discounted_base_price($flashDealProduct->product_id)}}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
