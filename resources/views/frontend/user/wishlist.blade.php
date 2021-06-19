@extends('frontend.layouts.master')
@section('title', 'User Wishlist')
@section('content')
    <main class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{('/')}}">Home</a></li>
                    <li><a href="">Account</a></li>
                    <li>Wishlist</li>
                </ul>
            </div>
        </div>
        <section class="ps-section--account">
            <div class="container">
                <div class="row">
                    @include('frontend.user.includes.user_sidebar')
                    <div class="col-lg-9">
                        <div class="ps-section__right">
                            <div class="ps-section--account-setting">
                                <div class="ps-section__header">
                                    <h2>Wishlist</h2>
                                </div>
                                <div class="ps-section__content">
                                    <div class="table-responsive">
                                        <table class="table ps-table--whishlist">
                                            <thead>
                                            <tr>
                                                <th>Product Image</th>
                                                <th>Product name</th>
                                                <th>Unit Price</th>
                                                <th>Stock Status</th>
                                                <th>Cart</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($wishlists as $wishlist)
                                            <tr>
                                                <td>
                                                    <div class="ps-product__thumbnail"><a href="{{route('product-details',$wishlist->product->slug)}}"><img src="{{url($wishlist->product->thumbnail_img)}}" alt="" width="100" height="100"></a></div>
                                                </td>
                                                <td>
                                                    <div class="ps-product--cart">
                                                        <div class="ps-product__content"><a href="{{route('product-details',$wishlist->product->slug)}}">{{$wishlist->product->name}}</a></div>
                                                    </div>
                                                </td>
                                                <td class="price">৳ {{$wishlist->product->unit_price}}</td>
{{--                                                if ($request->current_stock == 1){--}}
{{--                                                $product->current_stock = 100000;--}}
{{--                                                }else{--}}
{{--                                                $product->current_stock = 0;--}}
{{--                                                }--}}

                                                <td>
                                                    @if($wishlist->product->current_stock = 100000)
                                                        <span class="ps-tag ps-tag--in-stock">Available</span>
                                                    @else
                                                        <span class="ps-tag ps-tag--in-stock">Not Available</span>
                                                        @endif
                                                </td>
                                                <td>
                                                    <a class="ps-btn text-center" style="padding: 7px 12px 7px 12px; font-size: 14px;" href="{{route('product-details',$wishlist->product->slug)}}">Cart</a>
                                                    <a class="ps-btn text-center" style="padding: 7px 12px 7px 12px; font-size: 14px;" href="{{route('remove.wishlist',$wishlist->id)}}" id="add_to_cart">Remove</a>
                                                </td>
                                            </tr>
                                            @empty
{{--                                                <div>--}}
{{--                                                    <h3 class="text-danger">No wishlist available!</h3>--}}
{{--                                                </div>--}}
                                            @endforelse
                                            </tbody>
                                        </table>
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
@push('js')
@endpush
