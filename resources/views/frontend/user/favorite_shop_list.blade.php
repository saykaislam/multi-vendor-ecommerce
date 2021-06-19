@extends('frontend.layouts.master')
@section('title', 'User Favorite Shops')
@section('content')
    <main class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{('/')}}">Home</a></li>
                    <li><a href="">Account</a></li>
                    <li>Favorite Shops</li>
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
                                    <h2>Favorite Shops</h2>
                                </div>
                                <div class="ps-section__content">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th><strong>Shop Logo</strong></th>
                                                <th><strong>Shop name</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($favoriteShops as $favoriteShop)
                                                <tr>
                                                    <td>
                                                        <a href="{{route('shop.details',$favoriteShop->shop->slug)}}"><img src="{{url($favoriteShop->shop->logo)}}" alt="" width="100" height="100"></a>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                           <a href="{{route('shop.details',$favoriteShop->shop->slug)}}">{{$favoriteShop->shop->name}}</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
