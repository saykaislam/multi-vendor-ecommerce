@extends('frontend.layouts.master')
@section('title', $shop->name)
@section('content')
    <div class="ps-page--single">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>{{$shop->name}}</li>
                </ul>
            </div>
        </div>
        <div class="ps-vendor-store">
            <div class="container">
                <div class="ps-section__container">
                    <div class="ps-section__left">
                        <div class="ps-block--vendor">
                            <div class="ps-block__thumbnail"><img src="{{asset($shop->logo)}}" alt=""></div>
                            <div class="ps-block__container">
                                <div class="ps-block__header">
                                    <h4>{{$shop->name}}</h4>
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select>
                                    <p><strong>85% Positive</strong>  (62 rating)</p>
                                </div><span class="ps-block__divider"></span>
                                <div class="ps-block__content">
                                    <p><strong>{{$shop->name}}</strong>, Bangladesh’s no.1 online retailer was established in May 2019 with the aim and vision to become the one-stop shop for retail in New York with implementation of best practices both online</p><span class="ps-block__divider"></span>
                                    <p><strong>Address</strong> {{$shop->address}}</p>
                                    <figure>
                                        <figcaption>Foloow us on social</figcaption>
                                        <ul class="ps-list--social-color">
                                            <li><a class="facebook" href="{{$shop->facebook}}"><i class="fa fa-facebook"></i></a></li>
                                            <li><a class="twitter" href="{{$shop->twitter}}"><i class="fa fa-twitter"></i></a></li>
                                            <li><a class="linkedin" href="{{$shop->google}}"><i class="fa fa-google-plus"></i></a></li>
                                            <li><a class="feed" href="{{$shop->youtube}}"><i class="fa fa-youtube"></i></a></li>
                                        </ul>
                                    </figure>
                                </div>
                                <div class="ps-block__footer">
                                    <p>Call us directly<strong>(+880) 1771123456</strong></p>
                                    <p>or Or if you have any question</p><a class="ps-btn ps-btn--fullwidth" href="#">Contact Seller</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-section__right">
                        <div class="ps-block--vendor-filter">
                            <div class="ps-block__left">
                                <ul>
                                    <li class="active"><a href="#">Categories</a></li>
                                    {{--                                    <li><a href="#">Reviews</a></li>--}}
                                    {{--                                    <li><a href="#">About</a></li>--}}
                                </ul>
                            </div>
                            <div class="ps-block__right">
                                <form class="ps-form--search" action="http://nouthemes.net/html/martfury/index.html" method="get">
                                    <input class="form-control" type="text" placeholder="Search in this shop">
                                    <button><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="ps-vendor-best-seller" style="padding-bottom: 30px;">
                            <div class="ps-section__header">
                                <h3>Fetured Categories</h3>
                                <div class="ps-section__nav"><a class="ps-carousel__prev" href="#vendor-bestseller"><i class="icon-chevron-left"></i></a><a class="ps-carousel__next" href="#vendor-bestseller"><i class="icon-chevron-right"></i></a></div>
                            </div>
                            <div class="ps-section__content">
                                <div class="owl-slider" id="vendor-bestseller" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="2" data-owl-item-sm="3" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on">
                                    <div class="row">

                                        @foreach($shopCat as $cat)
                                    <div class="col-lg-3 col-md-6 ">
                                        <div class="container">
                                           <a href="{{route('category.products',$cat->category->slug)}}"> <img src="{{asset('uploads/categories/'.$cat->category->icon)}}" class="rounded-circle" alt="" width="100" height="100"></a>
                                            <div class="item-content">
                                            <h4 class="item-title">{{$cat->category->name}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
                                    </div>
{{--                                    @foreach($shopCat as $cat)--}}
{{--                                    <div class="ps-product">--}}
{{--                                        <div class="ps-product__thumbnail"><a href=""><i class="icon"><img src="{{asset('uploads/categories/'.$cat->category->icon)}}" alt=""></i></a>--}}
{{--                                            <div class="ps-product__badge">{{$cat->category->name}}</div>--}}
{{--                                            <ul class="ps-product__actions">--}}
{{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
{{--                                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
{{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
{{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
{{--                                            <div class="ps-product__content"><a class="ps-product__title" href="">Apple iPhone 7 Plus 128 GB – Red Color</a>--}}
{{--                                                <div class="ps-product__rating">--}}
{{--                                                    <select class="ps-rating" data-read-only="true">--}}
{{--                                                        <option value="1">1</option>--}}
{{--                                                        <option value="1">2</option>--}}
{{--                                                        <option value="1">3</option>--}}
{{--                                                        <option value="1">4</option>--}}
{{--                                                        <option value="2">5</option>--}}
{{--                                                    </select><span>01</span>--}}
{{--                                                </div>--}}
{{--                                                <p class="ps-product__price sale">$820.99 <del>$893.00</del></p>--}}
{{--                                            </div>--}}
{{--                                            <div class="ps-product__content hover"><a class="ps-product__title" href="">Apple iPhone 7 Plus 128 GB – Red Color</a>--}}
{{--                                                <p class="ps-product__price sale">$820.99 <del>$893.00</del></p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    @endforeach--}}
                                    {{--                                    <div class="ps-product">--}}
                                    {{--                                        <div class="ps-product__thumbnail"><a href=""><img src="{{asset('frontend/img/products/technology/3.jpg')}}" alt=""></a>--}}
                                    {{--                                            <div class="ps-product__badge">21%</div>--}}
                                    {{--                                            <ul class="ps-product__actions">--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                    {{--                                            </ul>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                    {{--                                            <div class="ps-product__content"><a class="ps-product__title" href="">Apple MacBook Air Retina 13.3-Inch Laptop</a>--}}
                                    {{--                                                <div class="ps-product__rating">--}}
                                    {{--                                                    <select class="ps-rating" data-read-only="true">--}}
                                    {{--                                                        <option value="1">1</option>--}}
                                    {{--                                                        <option value="1">2</option>--}}
                                    {{--                                                        <option value="1">3</option>--}}
                                    {{--                                                        <option value="1">4</option>--}}
                                    {{--                                                        <option value="2">5</option>--}}
                                    {{--                                                    </select><span>01</span>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <p class="ps-product__price sale">$1020.99 <del>$1120.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="ps-product__content hover"><a class="ps-product__title" href="">Apple MacBook Air Retina 13.3-Inch Laptop</a>--}}
                                    {{--                                                <p class="ps-product__price sale">$1020.99 <del>$1120.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="ps-product">--}}
                                    {{--                                        <div class="ps-product__thumbnail"><a href=""><img src="{{asset('frontend/img/products/technology/4.jpg')}}" alt=""></a>--}}
                                    {{--                                            <div class="ps-product__badge">18%</div>--}}
                                    {{--                                            <ul class="ps-product__actions">--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                    {{--                                            </ul>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                    {{--                                            <div class="ps-product__content"><a class="ps-product__title" href="">Samsung Gear VR Virtual Reality Headset</a>--}}
                                    {{--                                                <div class="ps-product__rating">--}}
                                    {{--                                                    <select class="ps-rating" data-read-only="true">--}}
                                    {{--                                                        <option value="1">1</option>--}}
                                    {{--                                                        <option value="1">2</option>--}}
                                    {{--                                                        <option value="1">3</option>--}}
                                    {{--                                                        <option value="1">4</option>--}}
                                    {{--                                                        <option value="2">5</option>--}}
                                    {{--                                                    </select><span>01</span>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <p class="ps-product__price sale">$64.99 <del>$80.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="ps-product__content hover"><a class="ps-product__title" href="">Samsung Gear VR Virtual Reality Headset</a>--}}
                                    {{--                                                <p class="ps-product__price sale">$64.99 <del>$80.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="ps-product">--}}
                                    {{--                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/5.jpg')}}" alt=""></a>--}}
                                    {{--                                            <div class="ps-product__badge">18%</div>--}}
                                    {{--                                            <ul class="ps-product__actions">--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                    {{--                                            </ul>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                    {{--                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Bose Bluetooth &amp; Wireless Speaker 2.0 – Blue</a>--}}
                                    {{--                                                <div class="ps-product__rating">--}}
                                    {{--                                                    <select class="ps-rating" data-read-only="true">--}}
                                    {{--                                                        <option value="1">1</option>--}}
                                    {{--                                                        <option value="1">2</option>--}}
                                    {{--                                                        <option value="1">3</option>--}}
                                    {{--                                                        <option value="1">4</option>--}}
                                    {{--                                                        <option value="2">5</option>--}}
                                    {{--                                                    </select><span>01</span>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <p class="ps-product__price sale">$42.99 <del>$52.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Bose Bluetooth &amp; Wireless Speaker 2.0 – Blue</a>--}}
                                    {{--                                                <p class="ps-product__price sale">$42.99 <del>$52.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="ps-product">--}}
                                    {{--                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/6.jpg')}}" alt=""></a>--}}
                                    {{--                                            <div class="ps-product__badge">17%</div>--}}
                                    {{--                                            <ul class="ps-product__actions">--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                    {{--                                            </ul>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                    {{--                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>--}}
                                    {{--                                                <div class="ps-product__rating">--}}
                                    {{--                                                    <select class="ps-rating" data-read-only="true">--}}
                                    {{--                                                        <option value="1">1</option>--}}
                                    {{--                                                        <option value="1">2</option>--}}
                                    {{--                                                        <option value="1">3</option>--}}
                                    {{--                                                        <option value="1">4</option>--}}
                                    {{--                                                        <option value="2">5</option>--}}
                                    {{--                                                    </select><span>01</span>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <p class="ps-product__price sale">$542.99 <del>$592.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>--}}
                                    {{--                                                <p class="ps-product__price sale">$542.99 <del>$592.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="ps-product">--}}
                                    {{--                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/7.jpg')}}" alt=""></a>--}}
                                    {{--                                            <div class="ps-product__badge">17%</div>--}}
                                    {{--                                            <ul class="ps-product__actions">--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                    {{--                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                    {{--                                            </ul>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                    {{--                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>--}}
                                    {{--                                                <div class="ps-product__rating">--}}
                                    {{--                                                    <select class="ps-rating" data-read-only="true">--}}
                                    {{--                                                        <option value="1">1</option>--}}
                                    {{--                                                        <option value="1">2</option>--}}
                                    {{--                                                        <option value="1">3</option>--}}
                                    {{--                                                        <option value="1">4</option>--}}
                                    {{--                                                        <option value="2">5</option>--}}
                                    {{--                                                    </select><span>01</span>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <p class="ps-product__price sale">$542.99 <del>$592.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>--}}
                                    {{--                                                <p class="ps-product__price sale">$542.99 <del>$592.00</del></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="ps-shopping ps-tab-root">
                            <div class="ps-shopping__header">
                                <h4><strong> </strong> Products found</h4>
                                <div class="ps-shopping__actions">
                                    {{--                                    <select class="ps-select" data-placeholder="Sort Items">--}}
                                    {{--                                        <option>Sort by latest</option>--}}
                                    {{--                                        <option>Sort by popularity</option>--}}
                                    {{--                                        <option>Sort by average rating</option>--}}
                                    {{--                                        <option>Sort by price: low to high</option>--}}
                                    {{--                                        <option>Sort by price: high to low</option>--}}
                                    {{--                                    </select>--}}
                                    {{--                                    <div class="ps-shopping__view">--}}
                                    {{--                                        <p>View</p>--}}
                                    {{--                                        <ul class="ps-tab-list">--}}
                                    {{--                                            <li class="active"><a href="#tab-1"><i class="icon-grid"></i></a></li>--}}
                                    {{--                                            <li><a href="#tab-2"><i class="icon-list4"></i></a></li>--}}
                                    {{--                                        </ul>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                            <div class="ps-tabs">
                                <div class="ps-tab active" id="tab-1">
                                    <div class="row">
{{--                                        @foreach($products as $product)--}}
{{--                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">--}}
{{--                                                <div class="ps-product">--}}
{{--                                                    <div class="ps-product__thumbnail"><a href="{{route('product-details',$product->slug)}}"><img src="{{asset($product->thumbnail_img)}}" alt=""></a>--}}
{{--                                                        <div class="ps-product__badge">11%</div>--}}
{{--                                                        <ul class="ps-product__actions">--}}
{{--                                                            <li><a href="{{route('product-details',$product->slug)}}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
{{--                                                            <li><a href="{{route('product-details',$product->slug)}}" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>--}}
{{--                                                            --}}{{--                                                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
{{--                                                            --}}{{--                                                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
{{--                                                        </ul>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="ps-product__container"><a class="ps-product__vendor" href="{{route('product-details',$product->slug)}}"></a>--}}
{{--                                                        <div class="ps-product__content"><a class="ps-product__title" href="">{{$product->name}}</a>--}}
{{--                                                            <div class="ps-product__rating">--}}
{{--                                                                <select class="ps-rating" data-read-only="true">--}}
{{--                                                                    <option value="1">1</option>--}}
{{--                                                                    <option value="1">2</option>--}}
{{--                                                                    <option value="1">3</option>--}}
{{--                                                                    <option value="1">4</option>--}}
{{--                                                                    <option value="2">5</option>--}}
{{--                                                                </select><span>01</span>--}}
{{--                                                            </div>--}}
{{--                                                            <p class="ps-product__price sale">৳{{$product->unit_price}} <del>৳{{$product->purchase_price}}</del></p>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="ps-product__content hover"><a class="ps-product__title" href="{{route('product-details',$product->slug)}}">{{$product->name}}</a>--}}
{{--                                                            <p class="ps-product__price sale">৳{{$product->unit_price}} <del>৳{{$product->purchase_price}}</del></p>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                            <div class="ps-product">
                                                <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/2.jpg')}}" alt=""></a>
                                                    <div class="ps-product__badge">11%</div>
                                                    <ul class="ps-product__actions">
                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                        <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone 7 Plus 128 GB – Red Color</a>
                                                        <div class="ps-product__rating">
                                                            <select class="ps-rating" data-read-only="true">
                                                                <option value="1">1</option>
                                                                <option value="1">2</option>
                                                                <option value="1">3</option>
                                                                <option value="1">4</option>
                                                                <option value="2">5</option>
                                                            </select><span>01</span>
                                                        </div>
                                                        <p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Apple iPhone 7 Plus 128 GB – Red Color</a>
                                                        <p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">--}}
                                        {{--                                            <div class="ps-product">--}}
                                        {{--                                                <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/3.jpg')}}" alt=""></a>--}}
                                        {{--                                                    <div class="ps-product__badge">21%</div>--}}
                                        {{--                                                    <ul class="ps-product__actions">--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                        {{--                                                    </ul>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                        {{--                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple MacBook Air Retina 13.3-Inch Laptop</a>--}}
                                        {{--                                                        <div class="ps-product__rating">--}}
                                        {{--                                                            <select class="ps-rating" data-read-only="true">--}}
                                        {{--                                                                <option value="1">1</option>--}}
                                        {{--                                                                <option value="1">2</option>--}}
                                        {{--                                                                <option value="1">3</option>--}}
                                        {{--                                                                <option value="1">4</option>--}}
                                        {{--                                                                <option value="2">5</option>--}}
                                        {{--                                                            </select><span>01</span>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <p class="ps-product__price sale">$1020.99 <del>$1120.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Apple MacBook Air Retina 13.3-Inch Laptop</a>--}}
                                        {{--                                                        <p class="ps-product__price sale">$1020.99 <del>$1120.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">--}}
                                        {{--                                            <div class="ps-product">--}}
                                        {{--                                                <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/4.jpg')}}" alt=""></a>--}}
                                        {{--                                                    <div class="ps-product__badge">18%</div>--}}
                                        {{--                                                    <ul class="ps-product__actions">--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                        {{--                                                    </ul>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                        {{--                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Samsung Gear VR Virtual Reality Headset</a>--}}
                                        {{--                                                        <div class="ps-product__rating">--}}
                                        {{--                                                            <select class="ps-rating" data-read-only="true">--}}
                                        {{--                                                                <option value="1">1</option>--}}
                                        {{--                                                                <option value="1">2</option>--}}
                                        {{--                                                                <option value="1">3</option>--}}
                                        {{--                                                                <option value="1">4</option>--}}
                                        {{--                                                                <option value="2">5</option>--}}
                                        {{--                                                            </select><span>01</span>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <p class="ps-product__price sale">$64.99 <del>$80.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Samsung Gear VR Virtual Reality Headset</a>--}}
                                        {{--                                                        <p class="ps-product__price sale">$64.99 <del>$80.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">--}}
                                        {{--                                            <div class="ps-product">--}}
                                        {{--                                                <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/5.jpg')}}" alt=""></a>--}}
                                        {{--                                                    <div class="ps-product__badge">18%</div>--}}
                                        {{--                                                    <ul class="ps-product__actions">--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                        {{--                                                    </ul>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                        {{--                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Bose Bluetooth &amp; Wireless Speaker 2.0 – Blue</a>--}}
                                        {{--                                                        <div class="ps-product__rating">--}}
                                        {{--                                                            <select class="ps-rating" data-read-only="true">--}}
                                        {{--                                                                <option value="1">1</option>--}}
                                        {{--                                                                <option value="1">2</option>--}}
                                        {{--                                                                <option value="1">3</option>--}}
                                        {{--                                                                <option value="1">4</option>--}}
                                        {{--                                                                <option value="2">5</option>--}}
                                        {{--                                                            </select><span>01</span>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <p class="ps-product__price sale">$42.99 <del>$52.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Bose Bluetooth &amp; Wireless Speaker 2.0 – Blue</a>--}}
                                        {{--                                                        <p class="ps-product__price sale">$42.99 <del>$52.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">--}}
                                        {{--                                            <div class="ps-product">--}}
                                        {{--                                                <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/6.jpg')}}" alt=""></a>--}}
                                        {{--                                                    <div class="ps-product__badge">17%</div>--}}
                                        {{--                                                    <ul class="ps-product__actions">--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                        {{--                                                    </ul>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                        {{--                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>--}}
                                        {{--                                                        <div class="ps-product__rating">--}}
                                        {{--                                                            <select class="ps-rating" data-read-only="true">--}}
                                        {{--                                                                <option value="1">1</option>--}}
                                        {{--                                                                <option value="1">2</option>--}}
                                        {{--                                                                <option value="1">3</option>--}}
                                        {{--                                                                <option value="1">4</option>--}}
                                        {{--                                                                <option value="2">5</option>--}}
                                        {{--                                                            </select><span>01</span>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <p class="ps-product__price sale">$542.99 <del>$592.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>--}}
                                        {{--                                                        <p class="ps-product__price sale">$542.99 <del>$592.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">--}}
                                        {{--                                            <div class="ps-product">--}}
                                        {{--                                                <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/7.jpg')}}" alt=""></a>--}}
                                        {{--                                                    <div class="ps-product__badge">17%</div>--}}
                                        {{--                                                    <ul class="ps-product__actions">--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
                                        {{--                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                        {{--                                                    </ul>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>--}}
                                        {{--                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>--}}
                                        {{--                                                        <div class="ps-product__rating">--}}
                                        {{--                                                            <select class="ps-rating" data-read-only="true">--}}
                                        {{--                                                                <option value="1">1</option>--}}
                                        {{--                                                                <option value="1">2</option>--}}
                                        {{--                                                                <option value="1">3</option>--}}
                                        {{--                                                                <option value="1">4</option>--}}
                                        {{--                                                                <option value="2">5</option>--}}
                                        {{--                                                            </select><span>01</span>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <p class="ps-product__price sale">$542.99 <del>$592.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>--}}
                                        {{--                                                        <p class="ps-product__price sale">$542.99 <del>$592.00</del></p>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                    <div class="ps-pagination">
                                        <ul class="pagination">
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">Next Page<i class="icon-chevron-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="ps-tab" id="tab-2">
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/1.jpg')}}" alt=""></a>
                                            <div class="ps-product__badge">11%</div>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone X 256GB T-Mobile – Black</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select><span>01</span>
                                                </div>
                                                <p class="ps-product__vendor">Sold by:<a href="#"></a></p>
                                                <ul class="ps-product__desc">
                                                    <li> Unrestrained and portable active stereo speaker</li>
                                                    <li> Free from the confines of wires and chords</li>
                                                    <li> 20 hours of portable capabilities</li>
                                                    <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                                    <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                                </ul>
                                            </div>
                                            <div class="ps-product__shopping">
                                                <p class="ps-product__price sale">$1389.99 <del>$1893.00</del></p><a class="ps-btn" href="#">Add to cart</a>
                                                <ul class="ps-product__actions">
                                                    <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                                    <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/2.jpg')}}" alt=""></a>
                                            <div class="ps-product__badge">11%</div>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone 7 Plus 128 GB – Red Color</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select><span>01</span>
                                                </div>
                                                <p class="ps-product__vendor">Sold by:<a href="#">Global Office</a></p>
                                                <ul class="ps-product__desc">
                                                    <li> Unrestrained and portable active stereo speaker</li>
                                                    <li> Free from the confines of wires and chords</li>
                                                    <li> 20 hours of portable capabilities</li>
                                                    <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                                    <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                                </ul>
                                            </div>
                                            <div class="ps-product__shopping">
                                                <p class="ps-product__price sale">$820.99 <del>$893.00</del></p><a class="ps-btn" href="#">Add to cart</a>
                                                <ul class="ps-product__actions">
                                                    <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                                    <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/3.jpg')}}" alt=""></a>
                                            <div class="ps-product__badge">21%</div>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple MacBook Air Retina 13.3-Inch Laptop</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select><span>01</span>
                                                </div>
                                                <p class="ps-product__vendor">Sold by:<a href="#">Global Office</a></p>
                                                <ul class="ps-product__desc">
                                                    <li> Unrestrained and portable active stereo speaker</li>
                                                    <li> Free from the confines of wires and chords</li>
                                                    <li> 20 hours of portable capabilities</li>
                                                    <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                                    <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                                </ul>
                                            </div>
                                            <div class="ps-product__shopping">
                                                <p class="ps-product__price sale">$1020.99 <del>$1120.00</del></p><a class="ps-btn" href="#">Add to cart</a>
                                                <ul class="ps-product__actions">
                                                    <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                                    <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/4.jpg')}}" alt=""></a>
                                            <div class="ps-product__badge">18%</div>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Samsung Gear VR Virtual Reality Headset</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select><span>01</span>
                                                </div>
                                                <p class="ps-product__vendor">Sold by:<a href="#">Global Office</a></p>
                                                <ul class="ps-product__desc">
                                                    <li> Unrestrained and portable active stereo speaker</li>
                                                    <li> Free from the confines of wires and chords</li>
                                                    <li> 20 hours of portable capabilities</li>
                                                    <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                                    <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                                </ul>
                                            </div>
                                            <div class="ps-product__shopping">
                                                <p class="ps-product__price sale">$64.99 <del>$80.00</del></p><a class="ps-btn" href="#">Add to cart</a>
                                                <ul class="ps-product__actions">
                                                    <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                                    <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/5.jpg')}}" alt=""></a>
                                            <div class="ps-product__badge">18%</div>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Bose Bluetooth &amp; Wireless Speaker 2.0 – Blue</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select><span>01</span>
                                                </div>
                                                <p class="ps-product__vendor">Sold by:<a href="#">Global Office</a></p>
                                                <ul class="ps-product__desc">
                                                    <li> Unrestrained and portable active stereo speaker</li>
                                                    <li> Free from the confines of wires and chords</li>
                                                    <li> 20 hours of portable capabilities</li>
                                                    <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                                    <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                                </ul>
                                            </div>
                                            <div class="ps-product__shopping">
                                                <p class="ps-product__price sale">$42.99 <del>$52.00</del></p><a class="ps-btn" href="#">Add to cart</a>
                                                <ul class="ps-product__actions">
                                                    <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                                    <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/6.jpg')}}" alt=""></a>
                                            <div class="ps-product__badge">17%</div>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select><span>01</span>
                                                </div>
                                                <p class="ps-product__vendor">Sold by:<a href="#">Global Office</a></p>
                                                <ul class="ps-product__desc">
                                                    <li> Unrestrained and portable active stereo speaker</li>
                                                    <li> Free from the confines of wires and chords</li>
                                                    <li> 20 hours of portable capabilities</li>
                                                    <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                                    <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                                </ul>
                                            </div>
                                            <div class="ps-product__shopping">
                                                <p class="ps-product__price sale">$542.99 <del>$592.00</del></p><a class="ps-btn" href="#">Add to cart</a>
                                                <ul class="ps-product__actions">
                                                    <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                                    <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/technology/7.jpg')}}" alt=""></a>
                                            <div class="ps-product__badge">17%</div>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select><span>01</span>
                                                </div>
                                                <p class="ps-product__vendor">Sold by:<a href="#">Global Office</a></p>
                                                <ul class="ps-product__desc">
                                                    <li> Unrestrained and portable active stereo speaker</li>
                                                    <li> Free from the confines of wires and chords</li>
                                                    <li> 20 hours of portable capabilities</li>
                                                    <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                                    <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                                </ul>
                                            </div>
                                            <div class="ps-product__shopping">
                                                <p class="ps-product__price sale">$542.99 <del>$592.00</del></p><a class="ps-btn" href="#">Add to cart</a>
                                                <ul class="ps-product__actions">
                                                    <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                                    <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ps-pagination">
                                        <ul class="pagination">
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">Next Page<i class="icon-chevron-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
