@extends('frontend.layouts.master')
@section('title', $productDetails->name)
@push('css')
    <style>
        [type=radio] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        /* IMAGE STYLES */
        /*[type=radio] + img {*/
        /*    cursor: pointer;*/
        /*}*/
        [type=radio] + label {
            cursor: pointer;
            padding: 10px 10px;
            background-color: #fff87a;
            color: #000000;
            border-radius: 6px;
        }

        /* CHECKED STYLES */
        /*[type=radio]:checked + img {*/
        /*    background-color: #f00;*/
        /*    outline: 2px solid #f00;*/
        /*    border-radius: 10px;*/
        /*}*/
        [type=radio]:checked + label {
            border: 4px solid #282727;
            color: #212121;
        }
    </style>
@endpush
@section('content')

    <div class="ps-breadcrumb">
        <div class="ps-container">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                {{--                <li><a href="shop-default.html">Consumer Electrics</a></li>--}}
                {{--                <li><a href="shop-default.html">Refrigerators</a></li>--}}
                <li>{{$productDetails->name}}</li>
            </ul>
        </div>
    </div>

    @php
        $shop=\App\Model\Shop::where('user_id',$productDetails->user_id)->first();
    @endphp

    <div class="ps-page--product">
        <div class="ps-container">
            <div class="ps-page__container">
                <div class="ps-page__left">
                    <div class="ps-product--detail ps-product--fullwidth">
                        <div class="ps-product__header">

                            <div class="ps-product__thumbnail" data-vertical="true">
                                @if(count($photos)!=0)
                                <figure>
                                    <div class="ps-wrapper">
                                        <div class="ps-product__gallery" data-arrow="true">
                                            @foreach($photos as $key => $photo)
                                            <div class="item"><a href="{{url($photo)}}"><img src="{{url($photo)}}" alt=""></a></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </figure>
                                @endif

                                <div class="ps-product__variants" data-item="4" data-md="4" data-sm="4" data-arrow="false">
                                    @foreach($photos as $pht)
                                    <div class="item"><img src="{{url($pht)}}" alt=""></div>
                                    @endforeach
{{--                                    <div class="item"><img src="{{asset('frontend/img/products/detail/fullwidth/2.jpg')}}" alt=""></div>--}}
{{--                                    <div class="item"><img src="{{asset('frontend/img/products/detail/fullwidth/3.jpg')}}" alt=""></div>--}}
                                </div>

                            </div>
                            <div class="ps-product__info">
                                <h1>{{ $productDetails->name }}</h1>
                                <div class="ps-product__meta">
                                    <p>Brand:<a href="{{url('/products/'.$shop->slug.'/'.$productDetails->brand->slug)}}">{{ $productDetails->brand->name }}</a></p>
                                    <p class="categories">
                                        <strong> Categories:</strong>
                                        <a href="{{url('/shop/'.$shop->slug.'/'.$productDetails->category->slug)}}">{{$productDetails->category->name}}</a>
                                    </p>
                                    <div class="ps-product__rating">
                                        <select class="ps-rating" data-read-only="true">
                                            @for ($i=0; $i < round($productDetails->rating); $i++)
                                                <option value="1">{{$i}}</option>
                                            @endfor
                                        </select><span>({{$reviews->count()}} review)</span>
                                    </div>
                                </div>
                                <h4 class="ps-product__price">৳ <span class="price ps-product__price">{{ $price }}</span></h4>
                                <div class="ps-product__price">
                                    <p class="">Unit: <strong>{{ $productDetails->unit }}</strong> </p>
                                </div>

                                <div class="ps-product__desc">

                                    <p>Sold By:<a href="{{route('shop.details',$shop->slug)}}"><strong> {{ $shop->name }}</strong></a></p>

                                   {{-- <ul class="ps-list--dot">
                                        <li>  {!!  Str::limit($productDetails->description, 60)!!}</li>
--}}{{--                                        <li> Free from the confines of wires and chords</li>--}}{{--
                                        --}}{{--                                        <li> 20 hours of portable capabilities</li>--}}{{--
                                        --}}{{--                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>--}}{{--
                                        --}}{{--                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>--}}{{--
                                    </ul>--}}
                                </div>
                                <form id="option-choice-form">
                                    @csrf
                                    <div class="ps-product__variations">
                                        @if(count($colors)!=0)
                                            <figure>
                                                <figcaption>Color</figcaption>
                                                @foreach($colors as $index=>$col)
                                                    <div class="form-check form-check-inline mr-0">
                                                        <input class="form-check-input" type="radio" name="color" id="{{$col->code}}" value="{{$col->name}}" @if($index == 0) checked @endif autocomplete="off">
                                                        <label class="form-check-label ps-variant ps-variant--color" for="{{$col->code}}" style="background-color: {{$col->code}}; border-radius: 50%;">
                                                            <span class="ps-variant__tooltip">{{$col->name}}</span>
                                                        </label>
                                                        {{--<div class="ps-variant ps-variant--color color--2"><span class="ps-variant__tooltip"> Gray</span></div>--}}
                                                    </div>
                                                @endforeach
                                                {{--                                            <div class="ps-variant ps-variant--color color--1"><span class="ps-variant__tooltip">Black</span></div>--}}
                                                {{--                                            <div class="ps-variant ps-variant--color color--2"><span class="ps-variant__tooltip"> Gray</span></div>--}}
                                            </figure>
                                        @endif
                                        @if(count($attributes)!=0)
                                            @foreach($attributes as $key=>$attr)
                                                @php
                                                    $att=\App\Model\Attribute::find($attr);
                                                @endphp
                                                <figure>
                                                    <figcaption>{{$att->name}}</figcaption>
                                                    @foreach($options[$key]->values as $index=>$val)
                                                        <div class="form-check form-check-inline mr-0">
                                                            <input class="form-check-input" type="radio" name="{{$att->name}}" id="{{$val}}" value="{{$val}}" @if($index == 0) checked @endif autocomplete="off">
                                                            <label class="form-check-label" for="{{$val}}">
                                                                {{$val}}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </figure>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="ps-product__shopping">
                                        <figure>
                                            <figcaption>Quantity</figcaption>
                                            <div class="form-group--number">
                                                <button class="up"><i class="fa fa-plus"></i></button>
                                                <button class="down"><i class="fa fa-minus"></i></button>
                                                <input class="form-control qtty" name="quantity" type="text" placeholder="1" value="1" autocomplete="off">
                                            </div>
                                        </figure>
                                        <p class="aval">{{$avilability}} available</p>
                                        @if($productDetails->current_stock > 0)
                                        <a class="ps-btn ps-btn--black" href="#" id="add_to_cart">Add to cart</a>
                                        @else
                                            <a class="ps-btn ps-btn--danger bg-danger" href="#" disabled="disabled">Stock Out</a>
                                        @endif


                                        {{--                                        <a class="ps-btn" href="#">Buy Now</a>--}}
                                        {{--                                        <div class="ps-product__actions"><a href="#"><i class="icon-heart"></i></a><a href="#"><i class="icon-chart-bars"></i></a></div>--}}
                                    </div>
                                </form>
{{--                                <div class="ps-product__specification"><a class="report" href="#">Report Abuse</a>--}}
{{--                                    <p><strong>SKU:</strong> SF1133569600-1</p>--}}
{{--                                    --}}{{--<p class="tags"><strong> Tags</strong><a href="#">sofa</a>,<a href="#">technologies</a>,<a href="#">wireless</a></p>--}}
{{--                                </div>--}}
{{--                                <div class="ps-product__sharing"><a class="facebook" href="#"><i class="fa fa-facebook"></i></a><a class="twitter" href="#"><i class="fa fa-twitter"></i></a><a class="google" href="#"><i class="fa fa-google-plus"></i></a><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></div>--}}
                            </div>
                        </div>
                        <div class="ps-product__content ps-tab-root">
                            <ul class="ps-tab-list">
                                <li class="active"><a href="#tab-1">Description</a></li>
{{--                                <li><a href="#tab-2">Specification</a></li>--}}
                                <li><a href="#tab-3">Shop</a></li>
                                <li><a href="#tab-4">Reviews</a></li>
                            </ul>
                            <div class="ps-tabs">
                                <div class="ps-tab active" id="tab-1">
                                    <div class="ps-document">
                                        <p>{!! $productDetails->description !!} </p>
                                    </div>
                                </div>

                                <div class="ps-tab" id="tab-3">
                                    <h4>{{ $shop->name }}</h4>
                                    <div class="address">Address: {{ $shop->address }}</div>
                                    <div>Email: {{ $shop->email }}</div>
                                    <div>Phone: {{ $shop->phone }}</div>
                                    <form action="{{route('shop.details',$shop->slug)}}" method="POST" style="padding-top: 10px">
                                        @csrf
                                        <a href="{{route('shop.details',$shop->slug)}}"> <button type="button" class="btn btn-lg btn-info">Go To Shop</button></a>
                                    </form>
                                    {{--                                    <a href="#">More Products from gopro</a>--}}
                                </div>
                                <div class="ps-tab" id="tab-4">
                                    <div class="row">
                                        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12 ">
                                            <div class="ps-block--average-rating">
                                                <div class="ps-block__header">
                                                    <h3>{{number_format((float)$productDetails->rating, 1, '.', '')}}</h3>
                                                    <select class="ps-rating" data-read-only="true">
                                                        @for ($i=0; $i < round($productDetails->rating); $i++)
                                                            <option value="1">{{$i}}</option>
                                                        @endfor
                                                        @foreach($reviews as $review)

                                                        @endforeach
                                                        {{--@for ($i=0; $i < 5-$productDetails->rating; $i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                        @endfor--}}
                                                        {{--@if($productDetails->rating >= 1)
                                                            <option value="1">1</option>
                                                        @else
                                                        @
                                                        @elseif($productDetails->rating >= 2 )
                                                            <option value="1">1</option>
                                                            <option value="1">2</option>
                                                        @elseif($productDetails->rating >= 3 )
                                                            <option value="1">1</option>
                                                            <option value="1">2</option>
                                                            <option value="1">3</option>
                                                        @elseif($productDetails->rating >= 4 )
                                                            <option value="1">1</option>
                                                            <option value="1">2</option>
                                                            <option value="1">3</option>
                                                            <option value="1">4</option>
                                                        @elseif($productDetails->rating >= 5 )
                                                            <option value="1">1</option>
                                                            <option value="1">2</option>
                                                            <option value="1">3</option>
                                                            <option value="1">4</option>
                                                            <option value="1">5</option>
                                                        @endif--}}
                                                    </select><span>{{$reviews->count()}} Review</span>
                                                </div>
                                                <div class="ps-block__star"><span>5 Star</span>
                                                    <div class="ps-progress" data-value="{{$fiveStarRev->count()}}"><span></span></div><span>{{$fiveStarRev->count()}}</span>
                                                </div>
                                                <div class="ps-block__star"><span>4 Star</span>
                                                    <div class="ps-progress" data-value="{{$fourStarRev->count()}}"><span></span></div><span>{{$fourStarRev->count()}}</span>
                                                </div>
                                                <div class="ps-block__star"><span>3 Star</span>
                                                    <div class="ps-progress" data-value="{{$threeStarRev->count()}}"><span></span></div><span>{{$threeStarRev->count()}}</span>
                                                </div>
                                                <div class="ps-block__star"><span>2 Star</span>
                                                    <div class="ps-progress" data-value="{{$twoStarRev->count()}}"><span></span></div><span>{{$twoStarRev->count()}}</span>
                                                </div>
                                                <div class="ps-block__star"><span>1 Star</span>
                                                    <div class="ps-progress " data-value="{{$oneStarRev->count()}}"><span></span></div><span>{{$oneStarRev->count()}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12 ">
                                            @forelse($reviewsComments as $reviews)
                                                @php
                                                    $userData = App\User::find($reviews->user_id)
                                                @endphp
                                            <div class="row">
                                                <div class="col-md-1 p-0 m-0">
                                                    <div class="ps-widget__header">
                                                        <img src="{{url($userData->avatar_original)}}" alt="" width="60">
                                                    </div>
                                                </div>
                                                <div class="col-md-2"><figcaption>{{$userData->name}}</figcaption></div>
                                                <div class="col-md-6">
                                                    <p>{{$reviews->comment}}</p>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="ps-rating" data-read-only="true">
                                                        @for ($i=0; $i < round($reviews->rating); $i++)
                                                            <option value="1">{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    <span style="font-size: 12px; font-style: italic;">{{$reviews->updated_at->diffForHumans()}}</span>
                                                </div>
                                            </div>
                                            <hr>
                                            @empty
                                                <div>
                                                    <h3 class="text-info">No review yet!!</h3>
                                                </div>
                                            @endforelse
                                            <div class="float-right">
                                                {{$reviewsComments->links()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="ps-tab" id="tab-5">--}}
{{--                                    <div class="ps-block--questions-answers">--}}
{{--                                        <h3>Questions and Answers</h3>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <input class="form-control" type="text" placeholder="Have a question? Search for answer?">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="ps-tab active" id="tab-6">--}}
{{--                                    <p>Sorry no more offers available</p>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-page__right">
{{--                    <aside class="widget widget_product widget_features">--}}
{{--                        <p><i class="icon-network"></i> Shipping worldwide</p>--}}
{{--                        <p><i class="icon-3d-rotate"></i> Free 7-day return if eligible, so easy</p>--}}
{{--                        <p><i class="icon-receipt"></i> Supplier give bills for this product.</p>--}}
{{--                        <p><i class="icon-credit-card"></i> Pay online or when receiving goods</p>--}}
{{--                    </aside>--}}
                    {{--                    <aside class="widget widget_sell-on-site">--}}
                    {{--                        <p><i class="icon-store"></i> Sell on Martfury?<a href="#"> Register Now !</a></p>--}}
                    {{--                    </aside>--}}
{{--                    <aside class="widget widget_ads"><a href="#"><img src="{{asset('frontend/img/ads/product-ads.png')}}" alt=""></a></aside>--}}

                    <aside class="widget widget_same-brand">
                        <h3>Same Brand</h3>
                        <div class="widget__content">
                            @foreach($relatedBrands  as $product)
                            <div class="ps-product">
                                <div class="ps-product__thumbnail">
                                    <a href="{{route('product-details',$product->slug)}}">
                                        <img src="{{url($product->thumbnail_img)}}" alt="" width="206" height="206">
                                    </a>
{{--                                    <div class="ps-product__badge">-37%</div>--}}
                                    <ul class="ps-product__actions">
                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                        <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                        <li><a href="{{route('add.wishlist',$product->id)}}" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="ps-product__container"><a class="ps-product__vendor" href="{{url('/products/'.$shop->slug.'/'.$product->brand->slug)}}">{{ $product->brand->name }}</a>
                                    <div class="ps-product__content"><a class="ps-product__title" href="{{route('product-details',$product->slug)}}">{{$product->name}}</a>
                                        Price: ৳ {{home_discounted_base_price($product->id)}}
                                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                            <del>৳ {{home_base_price($product->id)}}</del>
                                        @endif
                                    </div>
                                    <div class="ps-product__content hover"><a class="ps-product__title" href="{{route('product-details',$product->slug)}}">{{$product->name}}</a>
                                        Price: ৳ {{home_discounted_base_price($product->id)}}
                                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                            <del>৳ {{home_base_price($product->id)}}</del>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </aside>
                </div>
            </div>
            @if($categories->count() > 1)
            <div class="ps-section--default">
                <div class="ps-section__header">
                    <h3>Related products</h3>
                </div>

                <div class="ps-section__content">
                    <div class="ps-carousel--nav owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">
                        @foreach($categories as $product)
                            <div class="ps-product" style="margin-bottom: 20px;">
                                    <div class="ps-product__thumbnail"><a href="{{route('product-details',$product->slug)}}"><img src="{{url($product->thumbnail_img)}}" alt="" width="191" height="198"></a>
                                        <ul class="ps-product__actions">
                                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                            <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                            <li><a href="{{route('add.wishlist',$product->id)}}" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
{{--                                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
                                        </ul>
                                    </div>
                                    <div class="ps-product__container"><a class="ps-product__vendor" href="{{route('shop.details',$shop->slug)}}">{{$shop->name}}</a>
                                        <div class="ps-product__content"><a class="ps-product__title" href="{{route('product-details',$product->slug)}}">{{$product->name}}</a>
{{--                                            <div class="ps-product__rating">--}}
{{--                                                <select class="ps-rating" data-read-only="true">--}}
{{--                                                    <option value="1"></option>--}}
{{--                                                    <option value="1"></option>--}}
{{--                                                    <option value="1"></option>--}}
{{--                                                    <option value="1"></option>--}}
{{--                                                    <option value="2"></option>--}}
{{--                                                </select><span></span>--}}
{{--                                            </div>--}}
                                            Price: ৳ {{home_discounted_base_price($product->id)}}
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del>৳ {{home_base_price($product->id)}}</del>
                                            @endif
                                        </div>
                                        <div class="ps-product__content hover"><a class="ps-product__title" href="{{route('product-details',$product->slug)}}">{{$product->name}}</a>
                                            Price: ৳ {{home_discounted_base_price($product->id)}}
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del>৳ {{home_base_price($product->id)}}</del>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        @endforeach
{{--                        <div class="ps-product">--}}
{{--                            <div class="ps-product__thumbnail"><a href="product-default.html"><img src="{{asset('frontend/img/products/shop/19.jpg')}}" alt=""></a>--}}
{{--                                <ul class="ps-product__actions">--}}
{{--                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>--}}
{{--                                    <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>--}}
{{--                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>--}}
{{--                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <div class="ps-product__container"><a class="ps-product__vendor" href="#">Robert's Store</a>--}}
{{--                                <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">EPSION Plaster Printer</a>--}}
{{--                                    <div class="ps-product__rating">--}}
{{--                                        <select class="ps-rating" data-read-only="true">--}}
{{--                                            <option value="1">1</option>--}}
{{--                                            <option value="1">2</option>--}}
{{--                                            <option value="1">3</option>--}}
{{--                                            <option value="1">4</option>--}}
{{--                                            <option value="2">5</option>--}}
{{--                                        </select><span>01</span>--}}
{{--                                    </div>--}}
{{--                                    <p class="ps-product__price">$233.28</p>--}}
{{--                                </div>--}}
{{--                                <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">EPSION Plaster Printer</a>--}}
{{--                                    <p class="ps-product__price">$233.28</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
            @endif
        </div>
        <input type = "hidden" class="base_price" value="{{$price}}" autocomplete="off">
        <input type = "hidden" class="base_qty" value="{{$avilability}}" autocomplete="off">
    </div>
@endsection
@push('js')
    <script>
        $('.qtty').val(1);
        $('#option-choice-form input').on('change', function(){
            getVariantPrice($('#option-choice-form').serializeArray());
            console.log($('#option-choice-form').serializeArray());
        });
        $('#add_to_cart').on('click', function(e){
            e.preventDefault();
            //getVariantPrice($('#option-choice-form').serializeArray());
            addtocart($('#option-choice-form').serializeArray());
        });

        $('.up').on('click', function(event){
            event.preventDefault();
            var val=$('.qtty').val();
            var price=$('.price').html();
            var base_price=$('.base_price').val();
            var base_qty=$('.base_qty').val();
            // console.log(typeof base_qty);
            // console.log(typeof val);
            if(parseInt(val)<parseInt(base_qty)){
                $('.qtty').val(parseInt(val)+1);
                $('.price').html(parseInt(base_price)*(parseInt(val)+1));
            }

        });
        $('.down').on('click', function(event){
            event.preventDefault();
            var val=$('.qtty').val();
            var price=$('.price').html();
            var base_price=$('.base_price').val();
            if(parseInt(val)>1){
                $('.qtty').val(parseInt(val)-1);
                $('.price').html(parseInt(price)-parseInt(base_price));
            }
        });

        function getVariantPrice(array){
            console.log(array);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('product.variant.price')}}",
                method: "post",
                data:{
                    variant:array,
                },
                success: function(data){
                    console.log(data.response.price)
                    $('.price').html(data.response.price);
                    $('.base_price').val(data.response.price);
                    $('.aval').html(data.response.qty+" available");
                    $('.qtty').val(1);
                    $('.base_qty').val(data.response.qty);
                    //toastr.success('Lab Test added in your cart <span style="font-size: 25px;">&#10084;&#65039;</span>');
                }
            });
        }
        function addtocart(array){
            //console.log(array);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('product.add.cart')}}",
                method: "post",
                data:{
                    variant:array,
                    product_id: "{{$productDetails->id}}",
                    product_name:"{{$productDetails->name}}",
                    product_price:"{{$productDetails->unit_price}}",
                },
                success: function(data){
                    console.log(data.response)
                    $('.cart_count').html(data.response.countCart);
                    $('.cart_item').append(`<div class="ps-product--cart-mobile">
                                            <div class="ps-product__thumbnail"><a href="#"><img src="/${data.response['options'].image}" alt=""></a></div>
                                            <div class="ps-product__content"><a class="ps-product__remove" href=""><i class="icon-cross"></i></a><a href="#">${data.response.name}</a>
                                                <p><small>${data.response.qty} x ${data.response.price}</small>
                                            </div>
                                        </div>`);
                    $('.subTotal').html(data.response.subtotal);
                    // $('.base_price').val(data.response.price);
                    // $('.aval').html(data.response.qty+" available");
                    // $('.qtty').val(1);
                    // $('.base_qty').val(data.response.qty);
                    //toastr.success('Lab Test added in your cart <span style="font-size: 25px;">&#10084;&#65039;</span>');
                }
            });
        }

    </script>
@endpush
