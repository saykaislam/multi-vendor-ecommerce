@extends('frontend.layouts.master')
@section('title','Featured Product List')
@section('content')
    <div class="ps-breadcrumb">
        <div class="ps-container">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li>Products</li>
            </ul>
        </div>
    </div>
    <div class="ps-page--shop" id="shop-sidebar">
        <div class="container">
            <div class="ps-layout--shop">
                <div class="ps-layout__left">
                    <aside class="widget widget_shop">
                        <h4 class="widget-title">Categories</h4>
                        <ul class="ps-list--categories">
                            @foreach($categories as $Cat)
                                <li class="current-menu-item menu-item-has-children"><a href="#"> {{$Cat->category->name}} </a><span class="sub-toggle"><i class="fa fa-angle-down"></i></span>
                                    @php
                                        $subcategories = \App\Model\ShopSubcategory::where('category_id',$Cat->category_id)->where('shop_id',$shop->id)->latest()->get();
                                    @endphp
                                    <ul class="sub-menu">
                                        @foreach($subcategories as $subCat)
                                            <li class="current-menu-item "><a href="{{url('/products/'.$shop->slug.'/'.$Cat->category->slug.'/'.$subCat->subcategory->slug)}}">{{$subCat->subcategory->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </aside>
                    <aside class="widget widget_shop">
                        <h4 class="widget-title">BY BRANDS</h4>
                        <ul class="ps-list--categories">
                            @foreach($shopBrands as $brand)
                                <li class="current-menu-item menu-item-has-children"><a href="{{url('/products/'.$shop->slug.'/'.$brand->brand->slug)}}"> {{ $brand->brand->name }} </a>
                                </li>
                            @endforeach
                        </ul>
                    </aside>
                    <aside class="widget widget_shop">
                        {{--                        <h4 class="widget-title">BY BRANDS</h4>--}}
                        {{--                        <form class="ps-form--widget-search" action="http://nouthemes.net/html/martfury/do_action" method="get">--}}
                        {{--                            <input class="form-control" type="text" placeholder="">--}}
                        {{--                            <button><i class="icon-magnifier"></i></button>--}}
                        {{--                        </form>--}}
                        {{--                        <figure class="ps-custom-scrollbar" data-height="250">--}}
                        {{--                            @foreach($shopBrands as $brand)--}}
                        {{--                            <div class="ps-checkbox">--}}
                        {{--                                <input class="form-control" type="checkbox" id="{{$brand->brand_id}}" name="brand">--}}
                        {{--                                <label for="{{$brand->brand_id}}">{{ $brand->brand->name }}</label>--}}
                        {{--                            </div>--}}
                        {{--                            @endforeach--}}
                        {{--                        </figure>--}}
                        <figure>
                            <h4 class="widget-title">By Price</h4>
                            <div id="nonlinear"></div>
                            <p class="ps-slider__meta">Price:<span class="ps-slider__value">৳<span class="ps-slider__min"></span></span>-<span class="ps-slider__value">৳<span class="ps-slider__max"></span></span></p>
                        </figure>
                    </aside>
                </div>
                <div class="ps-layout__right">
                    <div class="ps-shopping ps-tab-root">
                        <div class="ps-shopping__header">
                            <p>Products found</p>
                        </div>
                        <div class="ps-tabs">
                            <div class="ps-tab active" id="tab-1">
                                <div class="ps-shopping-product" >
                                    <div class="row found_product" >
                                        @foreach($products as $product)
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                    <div class="ps-product__thumbnail"><a href="{{route('product-details',$product->slug)}}"><img src="{{url($product->thumbnail_img)}}" alt=""></a>
                                                        <ul class="ps-product__actions">
                                                            <li><a href="{{route('product-details',$product->slug)}}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                            <li><a href="{{route('product-details',$product->slug)}}" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                            <li><a href="{{route('add.wishlist',$product->id)}}" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                            {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                                        </ul>
                                                    </div>
                                                    <div class="ps-product__container"><a class="ps-product__vendor" href="{{route('shop.details',$shop->slug)}}">{{ $shop->name }}</a>
                                                        <div class="ps-product__content"><a class="ps-product__title" href="{{route('product-details',$product->slug)}}">{{$product->name}}</a>
                                                            {{--                                                        <p class="ps-product__price">৳ {{$product->unit_price}}</p>--}}
                                                            Price: ৳ {{home_discounted_base_price($product->id)}}
                                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                                <del>৳ {{home_base_price($product->id)}}</del>
                                                            @endif
                                                        </div>
                                                        <div class="ps-product__content hover"><a class="ps-product__title" href="{{route('product-details',$product->slug)}}">{{$product->name}}</a>
                                                            {{--                                                        <p class="ps-product__price">৳ {{$product->unit_price}}</p>--}}
                                                            Price: ৳ {{home_discounted_base_price($product->id)}}
                                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                                <del>৳ {{home_base_price($product->id)}}</del>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="filter_result" id="products"></div>
                                    </div>
                                    <div class="col-md-12 text-center" id="loader" style="display: none;">
                                        <img  src="{{asset('frontend/img/loader/loding3.gif')}}"  class="img-fluid " width="10%">
                                    </div>
                                </div>
                                <div class="ps-pagination" style="padding-left: 300px;">
                                    <ul class="ps-content-pagination ps-theme">
                                        {{$products->links()}}
                                    </ul>
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
    <script>
        var timeout = 0;
        function  update(values) {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                $('.filterdata').empty();
                $("#loader").show()
                $.get("{{url('/product/filter/')}}/"+values+'/shopId/'+{{$shop->id}},
                    function(data){

                        console.log(data)
                        $("#loader").hide()
                        $('.found_product').html(data);

                    });
                /* $.ajax({
                     type: 'GET', //THIS NEEDS TO BE GET
                     url: '/product/filter/'+values+'/sellerId/'+{{$shop->user_id}},
                    dataType: 'json',
                    success: function (data) {
                        //$('.found_product').empty();
                        console.log(data);
                        $('.found_product').html(data)
                    },error:function(){
                        console.log(data);
                    }
                });*/
            }, 1000);
        };
        function filterSlider() {
            $("#loader").show()
            var nonLinearSlider = document.getElementById('nonlinear');
            if (typeof nonLinearSlider != 'undefined' && nonLinearSlider != null) {
                noUiSlider.create(nonLinearSlider, {
                    connect: true,
                    behaviour: 'tap',
                    start: [0, 100000],
                    range: {
                        min: 0,
                        '2%': 200,
                        '3%': 500,
                        '5%': 1500,
                        '10%': 10000,
                        '20%': 20000,
                        '30%': 30000,
                        '40%': 40000,
                        '50%': 50000,
                        '60%': 60000,
                        '70%': 70000,
                        '80%': 80000,
                        '90%': 90000,
                        max: 100000,
                    },
                });
                var nodes = [
                    document.querySelector('.ps-slider__min'),
                    document.querySelector('.ps-slider__max'),
                ];

                nonLinearSlider.noUiSlider.on('update', function(values, handle) {
                    //console.log(values)
                    var wto;
                    nodes[handle].innerHTML = Math.round(values[handle]);
                    var filter_price = Math.round(values[handle]);
                    /*clearTimeout(wto);
                    wto  = setTimeout(function() {
                        $.ajax({
                            type: 'GET', //THIS NEEDS TO BE GET
                            url: '/product/filter/'+values,
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                            },error:function(){
                                console.log(data);
                            }
                        });
                    }, 5000);*/

                    update(values);


                });
            }
        }
    </script>
@endpush
