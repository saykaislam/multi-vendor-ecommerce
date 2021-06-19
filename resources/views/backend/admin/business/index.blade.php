@extends('backend.layouts.master')
@section("title","Set Commission")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Set Commission</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Set Commission</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content" style="margin-top: 50px">
        <div class="row">
            <div class="col-8 offset-2">
                <!-- general form elements -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Set Commission</h3>
                        <div class="float-right">
{{--                            <a href="{{route('admin.sellers.index')}}">--}}
{{--                                <button class="btn btn-success">--}}
{{--                                    <i class="fa fa-backward"> </i>--}}
{{--                                    Back--}}
{{--                                </button>--}}
{{--                            </a>--}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                        <div class="card-body">
                            <label>Commission <small class="text-info" >(Commission will be {{$sellerCommission->value}} percent (%) for all seller.) </small></label>
                            <form id="seller_commission">
                                <div class="input-group mb-3">
                                    <input type="hidden" class="form-control" name="id" value="{{$sellerCommission->id}}">
                                    <input type="text" class="form-control" name="value" value="{{$sellerCommission->value}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info">Update</button>
                                    </div>
                                </div>
                            </form>

                            <label>Refferal Value <small class="text-info" >(Refferal Value will be {{$refferalValue->value}} tk for all Customer.)</small></label>
                            <form id="refferal_value">
                                <div class="input-group mb-3">
                                    <input type="hidden" class="form-control" name="id" value="{{$refferalValue->id}}">
                                    <input type="text" class="form-control" name="value" value="{{$refferalValue->value}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info">Update</button>
                                    </div>
                                </div>
                            </form>

                            <label>First Order Discount <small class="text-info" >(First Order DIscount will be {{$firstOrderDiscount->value}} tk for all Customer.)</small></label>
                            <form id="first_order_value">
                                <div class="input-group mb-3">
                                    <input type="hidden" class="form-control" name="id" value="{{$firstOrderDiscount->id}}">
                                    <input type="text" class="form-control" name="value" value="{{$firstOrderDiscount->value}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info">Update</button>
                                    </div>
                                </div>
                            </form>

                            {{--                            <div class="form-group">--}}
{{--                                <label for="commission">Commission <small class="text-info" >(Commission will be  percent (%) for all seller.)</small></label>--}}
{{--                                <input type="number" class="form-control" name="value" value="" id="commission" placeholder="Set Commission for this seller" required>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="commission">Refferal Value <small class="text-info" >(Refferal Value will be  tk for all Customer.)</small></label>--}}
{{--                                <input type="number" class="form-control" name="refferal_value" value="" id="refferal_value" placeholder="Set refferal value for customer" required>--}}
{{--                            </div>--}}
                        </div>
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script>
        $("#seller_commission").submit(function(event){
            event.preventDefault();
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();
            console.log(serializedData)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({

                url: "{{url('/admin/seller/commission/update')}}",
                type: 'POST',
                data: $('#seller_commission').serialize(),
                success: function(data) {
                   // console.log(data);
                    toastr.success('Seller Commission Updated Successfully');
                }
            });
        })

        $("#refferal_value").submit(function(event){
            event.preventDefault();
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();
            console.log(serializedData)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{url('/admin/refferal/value/update')}}',
                data: $('#refferal_value').serialize(),
                success: function(data) {
                    // console.log(data);
                    toastr.success('Refferal Value Updated Successfully');
                }
            });
        })

        $("#first_order_value").submit(function(event){
            event.preventDefault();
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();
            console.log(serializedData)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{url('/admin/first_order/value/update')}}',
                data: $('#first_order_value').serialize(),
                success: function(data) {
                    // console.log(data);
                    toastr.success('First Order Value Updated Successfully');
                }
            });
        })

    </script>
@endpush
