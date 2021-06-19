@extends('frontend.layouts.master')
@section('title', 'Checkout')
@push('css')
    <style>
        .form_height{
            height: 40px;
        }
    </style>
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
            background-color: #fff;
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
            /*border: 2px solid #282727;*/
            background: #fcb800;
            color: #212121;
        }
    </style>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/gh/barikoi/barikoi-js@b6f6295467c19177a7d8b73ad4db136905e7cad6/dist/barikoi.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
          integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
            integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
            crossorigin=""></script>
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
@endpush
@section('content')
    <div class="ps-page--simple">
        <div class="ps-breadcrumb" style="background: #fff;">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Checkout</li>
                </ul>
            </div>
        </div>
        <div class="ps-checkout ps-section--shopping" style="background: #f3f3f3;">
            <div class="container">
                <div class="ps-section__content">
                    <form class="ps-form--checkout" action="{{route('checkout.order.submit')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="">Name <small class="text-danger">(You can change delivery name)</small></label>
                                    <input type="text" class="form-control form_height form-control-sm" name="name" value="{{Auth::user()->name}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12  ">
                                <div class="ps-form__billing-info">
                                    <h3 class="ps-form__heading">Shipping Details</h3>
                                    <div class="row">
                                        @if(!empty($addresses))
                                            @foreach($addresses as $address)
                                                <div class="col-md-6 col-12" style="padding-bottom: 15px;">
                                                    <div class="card" style="width: 35rem;">
{{--                                                        <div class="ps-radio">--}}
{{--                                                            <input class="form-control" type="radio" id="not-show" name="not-show">--}}
{{--                                                            <label for="not-show"></label>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="text-right dropdown">--}}
{{--                                                            <button class="btn bg-black" type="button" id="dropdownMenuButton" data-toggle="dropdown" style="background: #f1f1f1;">--}}
{{--                                                                <i class="fa fa-ellipsis-v"></i>--}}
{{--                                                            </button>--}}
{{--                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 14px;">--}}
{{--                                                                @if($address->set_default == 0)--}}
{{--                                                                    <form action="{{route('user.update.status',$address->id)}}" method="POST">--}}
{{--                                                                        @csrf--}}
{{--                                                                        <button class="btn btn-lg"> Make Default</button>--}}
{{--                                                                    </form>--}}
{{--                                                                @endif--}}
{{--                                                                <form action="{{route('user.address.destroy',$address->id)}}" method="POST">--}}
{{--                                                                    @csrf--}}
{{--                                                                    @method('DELETE')--}}
{{--                                                                    <button class="btn btn-lg"><a class="dropdown-item"> Delete </a></button>--}}
{{--                                                                </form>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}

                                                        <div class="card-body">
                                                            <div class="ps-radio">
                                                                <input class="form-check-input" type="radio" name="address_id" id="{{$address->id}}" value="{{$address->id}}" {{$address->set_default == 1 ? 'checked' : ''}}>
                                                                <label class="form-check-label" for="{{$address->id}}" style="background: #f3f3f3; color: #f3f3f3;">
                                                                </label>
                                                            </div>
                                                            <div class="card-text">Address: <strong>{{$address->address}}</strong></div>
                                                            <div class="card-text">Postal Code: <strong>{{$address->postal_code}}</strong></div>
                                                            <div class="card-text">City: <strong>{{$address->city}}</strong></div>
                                                            <div class="card-text">Country: <strong>{{$address->country}}</strong></div>
                                                            <div class="card-text">Phone: <strong>{{$address->phone}}</strong>
{{--                                                                @if($address->set_default == 1)--}}
{{--                                                                    <a href="#" class="btn btn-primary" style="margin-left: 100px;">Default</a>--}}
{{--                                                                @endif--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-md-6 col-12" style="padding-bottom: 15px;">
                                                <div class="card" style="width: 35rem; height: 12rem;">
                                                    <div class="card-body">
                                                        <h3 class="text-center">
                                                            <a data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-plus"></i></a>
                                                            <p>Add new Address</p>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-6 col-12">
                                                <div class="card" style="width: 30rem; height: 12rem;">
                                                    <div class="card-body">
                                                        <h3 class="text-center">
                                                            <a data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-plus"></i></a>
                                                            <p>Add new Address</p>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php
                            $order = \App\Model\Order::where('user_id',Auth::id())->first();

                            $offer = \App\Model\BusinessSetting::where('type','first_order_discount')->first();
                            @endphp
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12  ">
                                <div class="ps-form__total">
                                    <h3 class="ps-form__heading">Your Order</h3>
                                    <div class="content">
                                        <div class="ps-block--checkout-total">
                                            <div class="ps-block__header">
                                                <p>Products</p>
                                            </div>
                                            <div class="ps-block__content">
                                                <table class="table ps-block__products">
                                                    <tbody>
                                                    @php $totalVat = 0.00; $totalLabourCost = 0.00@endphp
                                                    @foreach(Cart::content() as $product)
                                                        @php
                                                            $totalVat +=  $product->options->vat * $product->qty;
                                                            $totalLabourCost +=  $product->options->labour_cost * $product->qty;
                                                        @endphp
                                                        <tr style="border-bottom: 1px solid #ddd;">
                                                            <td>
                                                                <a href="#"> {{$product->name}} ×{{$product->qty}}</a>
                                                                <div>VAT:<strong class="text-dark"> ৳{{$product->options->vat * $product->qty}}</strong></div>
                                                                @if($totalLabourCost > 0)
                                                                <div>Labour Cost:<strong class="text-dark"> ৳{{$product->options->labour_cost * $product->qty}}</strong></div>
                                                                @endif
                                                                {{--<p>Sold By:<strong>{{$product->options->shop_name}}</strong></p>--}}

                                                            </td>
                                                            <td >Subtotal: ৳{{$product->subtotal()}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <h4 class="ps-block__title">Total VAT: <span>৳{{$totalVat}}</span></h4>
                                                <h4 class="ps-block__title">Subtotal: <span>৳{{Cart::subtotal()}}</span></h4>
                                                @if(empty($order))
                                                    <h4 class="ps-block__title">Discount: <span>৳{{$offer->value}}</span></h4>
                                                    <h3>Total: <span>৳{{(Cart::total() +$totalVat + $totalLabourCost) - $offer->value}}</span></h3>
                                                @else
                                                    <h3>Total: <span>৳{{Cart::total() + $totalVat + $totalLabourCost}}</span></h3>
                                                @endif

                                            </div>
                                            <div class="row my-3" style="padding-top: 10px; padding-bottom: 10px;">
                                                <div class="col-md-12 text-center">
                                                    <div class="form-check form-check-inline mr-0">
                                                        <input class="form-check-input" type="radio" name="pay" id="cod" value="cod" checked autocomplete="off" >
                                                        <label class="form-check-label" for="cod" style="">
                                                           Cash On Delivery
                                                        </label>
                                                    </div>
{{--                                                    <div class="form-check form-check-inline mr-0">--}}
{{--                                                        <input class="form-check-input" type="radio" name="pay" id="ssl" value="ssl" checked autocomplete="off">--}}
{{--                                                        <label class="form-check-label" for="ssl" style="">--}}
{{--                                                            Online Pay--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
                                                </div>
                                            </div>
                                        </div><button class="ps-btn ps-btn--fullwidth" >Submit Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Your Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="ps-form--account-setting" id="bk_address" action="{{route('user.address.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="ps-form__content" >
                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="bksearch" class="">Area</label>
                                <input type="text" onkeyup="getAddress3()" placeholder="Search Your Area" class="form-control form_height form-control-sm address3" autocomplete="off">
                            </div>
                        </div>
                        <ul class="list-group addList3" style="padding: 0;">

                        </ul>
                        <div class="form-group">
                            <input type="hidden" name="city">
                            <input type="hidden" name="area">
                            <input type="hidden" name="postal_code">
                            <input type="hidden" name="latitude">
                            <input type="hidden" name="longitude">
                        </div>
                        <div class="form-group ">
                            <label for="country" class="">Country</label>
                            <input type="text" class="form-control form_height form-control-sm" name="country" placeholder="Bangladesh" readonly>
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label for="postal_code" class="">Postal Code</label>--}}
{{--                            <input type="text" class="form-control form-control-sm" name="postal_code" placeholder="Your Postal Code" readonly>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label for="phone" class="">Phone</label>
                            <input type="text" class="form-control form_height form-control-sm" name="phone" placeholder="Your phone">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="">Address</label>
                            <textarea name="address" id="address" rows="3" placeholder="Enter Your Address (e.g. 4th Floor, BBTOA Building,9 No South, Mirpur Rd )"  class="form-control"></textarea>
                            <small class="text-info"><i class="fa fa-info-circle"></i> e.g. 4th Floor, BBTOA Building,9 No South, Mirpur Rd</small>
                        </div>
                        <div class="form-group ">
                            <label for="phone" class="">Type</label>
                            <select name="type" id="type" class="form_height form-control" required>
                                <option value="Home">Home</option>
                                <option value="Office">Office</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group submit text-center">
                        <button class="ps-btn">Save</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
    </div>

@endsection
@push('js')
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2();
        /*$('.textarea').wysihtml5({
            toolbar: { fa: true }
        })*/
    </script>
    <script src="https://cdn.jsdelivr.net/gh/barikoi/barikoi-js@b6f6295467c19177a7d8b73ad4db136905e7cad6/dist/barikoi.min.js?key:MTg3NzpCRE5DQ01JSkgw"></script>
    <script>
        Bkoi.onSelect(function () {
            // get selected data from dropdown list
            let selectedPlace = Bkoi.getSelectedData()
            console.log(selectedPlace)
            // center of the map
            document.getElementsByName("address")[0].value = selectedPlace.address;
            document.getElementsByName("city")[0].value = selectedPlace.city;
            document.getElementsByName("area")[0].value = selectedPlace.area;
            document.getElementsByName("latitude")[0].value = selectedPlace.latitude;
            document.getElementsByName("longitude")[0].value = selectedPlace.longitude;

        })

        function getAddress3() {
            let places=[];
            let location=null;
            let add=$('.address3').val();
            console.log(add);
            $('.addList3').empty();
            fetch("https://barikoi.xyz/v1/api/search/autocomplete/MTg5ODpJUTVHV0RWVFZP/place?q="+add)
                .then(response => response.json())
                .catch(error => console.error('Error:', error))
                .then(response => {
                    response.places.forEach(result3)
                })
        }
        function result3(item, index){
            var $li = $("<li class='list-group-item'><a href='#' class='list-group-item bg-light'>" + item.address + "</a></li>");
            $(".addList3").append($li);
            $li.on('click', getPlacesDetails3.bind(this, item));
        }
        function getPlacesDetails3(mapData)
        {
            $(".addList3").empty();
            $( ".address3" ).val(mapData.address)
            $( "input[name='city']" ).val(mapData.city)
            $( "input[name='area']" ).val(mapData.area)
            $( "input[name='latitude']" ).val(mapData.latitude)
            $( "input[name='longitude']" ).val(mapData.longitude)
            $( "input[name='postal_code']" ).val(mapData.postCode)
            //console.log(mapData)
        }

    </script>
@endpush
