@extends('frontend.layouts.master')
@section('title', 'Shopping Cart')
@push('css')
@endpush
@section('content')
    <div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}l">Home</a></li>
                    <li>Shoping Cart</li>
                </ul>
            </div>
        </div>
        <div class="ps-section--shopping ps-shopping-cart pt-3">
            <div class="container">
                {{--                <div class="ps-section__header">--}}
                {{--                    <h1>Shopping Cart</h1>--}}
                {{--                </div>--}}
                <div class="ps-section__content">
                    <div class="table-responsive">
                        <table class="table ps-table--shopping-cart">
                            <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Product name</th>
                                <th>PRICE</th>
                                <th>QUANTITY</th>
                                <th>TOTAL</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(Cart::content() as $product)
                                <tr>
                                    <td>
                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="/{{$product->options->image}}" alt="" width="100" height="100" ></a></div>
                                    </td>
                                    <td>
                                        <div class="ps-product--cart">
                                            <div class="ps-product__content"><a href="product-default.html">{{$product->name}}</a>
                                                <p>Sold By:<strong> {{$product->options->shop_name}}</strong></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price">৳{{$product->price}}</td>
                                    <td>
                                        <div class="form-group--number">
                                            {{--                                        <button class="up">+</button>--}}
                                            {{--                                        <button class="down">-</button>--}}
                                            {{--                                            <input class="form-control" type="number" placeholder="1" value="1" min="1">--}}
                                            <form method="post" action="{{route('qty.update')}}">
                                                @csrf
                                                <input type="number" name="quantity" class="input-text" value="{{$product->qty}}" min="1" title="Qty" size="4" onchange="this.form.submit()">
                                                <input type = "hidden" name="rid" value="{{$product->rowId}}">
                                            </form>
                                        </div>
                                    </td>
                                    <td>৳{{$product->subtotal()}}</td>
                                    <td><a href="{{route('product.cart.remove',$product->rowId)}}"><i class="icon-cross"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(Cart::count()==0)
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src = "https://cdn.dribbble.com/users/204955/screenshots/4930541/emptycart.png?compress=1&resize=400x300" alt = "">
                                    <h3 class="text-danger">Empty Cart</h3>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="ps-section__cart-actions"><a class="ps-btn" href="{{url('/')}}"><i class="icon-arrow-left"></i> Back to Shop</a><a class="ps-btn" href="{{route('product.clear.cart')}}"><i class="fa fa-trash" aria-hidden="true"></i>Clear All</a></div>
                </div>
                @if(Cart::count()!=0)
                    <div class="ps-section__footer">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                {{--                            <figure>--}}
                                {{--                                <figcaption>Coupon Discount</figcaption>--}}
                                {{--                                <div class="form-group">--}}
                                {{--                                    <input class="form-control" type="text" placeholder="">--}}
                                {{--                                </div>--}}
                                {{--                                <div class="form-group">--}}
                                {{--                                    <button class="ps-btn ps-btn--outline">Apply</button>--}}
                                {{--                                </div>--}}
                                {{--                            </figure>--}}
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                {{--                            <figure>--}}
                                {{--                                <figcaption>Calculate shipping</figcaption>--}}
                                {{--                                <div class="form-group">--}}
                                {{--                                    <select class="ps-select">--}}
                                {{--                                        <option value="1">America</option>--}}
                                {{--                                        <option value="2">Italia</option>--}}
                                {{--                                        <option value="3">Vietnam</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="form-group">--}}
                                {{--                                    <input class="form-control" type="text" placeholder="Town/City">--}}
                                {{--                                </div>--}}
                                {{--                                <div class="form-group">--}}
                                {{--                                    <input class="form-control" type="text" placeholder="Postcode/Zip">--}}
                                {{--                                </div>--}}
                                {{--                                <div class="form-group">--}}
                                {{--                                    <button class="ps-btn ps-btn--outline">Update</button>--}}
                                {{--                                </div>--}}
                                {{--                            </figure>--}}
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="ps-block--shopping-total">
                                    <div class="ps-block__header">
                                        <p>Subtotal <span> {{Cart::subtotal()}}</span></p>
                                    </div>
                                    <div class="ps-block__header">
                                        <strong class="font-weight-bold"><p>Grandtotal <span> {{Cart::total()}}</span></p></strong>
                                    </div>
{{--                                    <div class="ps-block__content">--}}
{{--                                        <ul class="ps-block__product">--}}
{{--                                            <li><span class="ps-block__shop">YOUNG SHOP Shipping</span><span class="ps-block__shipping">Free Shipping</span><span class="ps-block__estimate">Estimate for <strong>Viet Nam</strong><a href="#"> MVMTH Classical Leather Watch In Black ×1</a></span></li>--}}
{{--                                            <li><span class="ps-block__shop">ROBERT’S STORE Shipping</span><span class="ps-block__shipping">Free Shipping</span><span class="ps-block__estimate">Estimate for <strong>Viet Nam</strong><a href="#">Apple Macbook Retina Display 12” ×1</a></span></li>--}}
{{--                                        </ul>--}}
{{--                                        <h3>Total <span>$683.49</span></h3>--}}
{{--                                    </div>--}}
                                </div><a class="ps-btn ps-btn--fullwidth" href="{{route('checkout')}}">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{--    <div class="ps-newsletter">--}}
    {{--        <div class="container">--}}
    {{--            <form class="ps-form--newsletter" action="http://nouthemes.net/html/martfury/do_action" method="post">--}}
    {{--                <div class="row">--}}
    {{--                    <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 ">--}}
    {{--                        <div class="ps-form__left">--}}
    {{--                            <h3>Newsletter</h3>--}}
    {{--                            <p>Subcribe to get information about products and coupons</p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12 ">--}}
    {{--                        <div class="ps-form__right">--}}
    {{--                            <div class="form-group--nest">--}}
    {{--                                <input class="form-control" type="email" placeholder="Email address">--}}
    {{--                                <button class="ps-btn">Subscribe</button>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </form>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection
