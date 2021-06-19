@extends('backend.layouts.master')
@section("title","Flash Deals Products")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('backend/dist/css/spectrum.css')}}">
    <style>
        .input-group-addon {
            padding: 6px 2px;
            font-size: 20px;
            font-weight: 400;
            line-height: 1;
            color: #555;
            text-align: center;
            background-color: #eee;
            border: 1px solid #ccc;
        }
        .input-daterange .input-group-addon {
            width: auto;
            min-width: 21px;
            padding: 4px 19px;
            line-height: 1.42857143;
            border-width: 1px 0;
            margin-left: -5px;
            margin-right: -5px;
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Flash Deals Title: <span class="badge badge-warning">{{$flashDeal->title}}</span></h1>
                </div>
               {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add Flash Deals Products</li>
                    </ol>
                </div>--}}
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <form role="form" id="choice_form" action="{{route('admin.flash_deals.products.store')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <section class="content">
            <div class="row m-2">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-info card-outline">
                        <p class="pl-2 pb-0 mb-0 bg-info">Add Products For This Flash Deals</p>
                        <div class="card-body">
                            <input type="hidden" name="flash_deal_id" value="{{$flashDeal->id}}">
                            <div class="row">
                                <div class="form-group mb-3 col-sm-12">
                                    <label class="control-label" for="shop">Shop</label>
                                    <div class="">
                                        <select name="shop" id="shop" class="form-control demo-select2"  data-placeholder="Shop">
                                            <option >Please select one shop</option>
                                            @foreach(\App\Model\Shop::get() as $shop)
                                                @if($shop->seller->verification_status == 1)
                                                <option value="{{$shop->user_id}}">{{$shop->name}} ({{$shop->user->name}})</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-3 col-sm-12">
                                    <label class="control-label" for="products">Products</label>
                                    <div class="" id="productsDiv">

                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="form-group" id="discount_table">

                            </div>
                            <div>
                                <button class="btn btn-success float-right">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@stop
@push('js')
    <script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/ckeditor/ckeditor.js')}}"></script>
    <script>
        $('#shop').on('change', function() {
            $('#productsDiv').find('ul').remove();
            $('#productsDiv').html(`<select name="products[]" id="products" class="form-control demo-select2 products" multiple required data-placeholder="Choose Products"></select>`)
            //alert( this.value );
            $.ajax({
                url: "{{url('admin/flash_deals/shop/products')}}/"+this.value,
                type: 'GET',
                success: function(data) {
                    $('.demo-select2').select2();
                    //console.log(data.response);
                    $('#discount_table').html(null);
                    data.response.map((product) => $('.products').append(`<option value="${product.id}">${product.name}</option>`))
                    productListGet()

                }
            });
        });
        $('.demo-select2').select2();
        $("#demo-dp-range .input-daterange").datepicker({
            startDate: "-0d",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true,
        });
        $(document).ready(function(){

        });
        function productListGet(){
            $('#products').on('change', function(){
                //alert('inside ')
                var product_ids = $('.products').val();
                console.log(product_ids);
                if(product_ids.length > 0){
                    $.post('{{ route('admin.flash_deals.product_discount') }}', {_token:'{{ csrf_token() }}', product_ids:product_ids}, function(data){
                    $('#discount_table').html(data);
                    $('.demo-select2').select2();
                });
            }
            else{
                $('#discount_table').html(null);
            }
            });
        }



    </script>
@endpush
