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
    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
            <!-- general form elements -->
                <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title float-left">Set Commission For all Sellers</h3>
                    <div class="float-right">
                        <a href="{{route('admin.sellers.index')}}">
                            <button class="btn btn-success">
                                <i class="fa fa-backward"> </i>
                                Back
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route('admin.seller.commission.update',$commission->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="commission">Commission <small class="text-info" >(Commission will be {{$commission->value}} percent (%) for all seller.)</small></label>
                            <input type="number" class="form-control" name="value" value="{{$commission->value}}" id="commission" placeholder="Set Commission for this seller" required>
                        </div>
                        <div class="form-group">
                            <label for="commission">Refferal Value <small class="text-info" >(Refferal Value will be {{$commission->refferal_value}} tk for all Customer.)</small></label>
                            <input type="number" class="form-control" name="refferal_value" value="{{$commission->refferal_value}}" id="refferal_value" placeholder="Set refferal value for customer" required>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>

@stop
@push('js')

@endpush
