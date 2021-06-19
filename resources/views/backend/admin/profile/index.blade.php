@extends('backend.layouts.master')
@section('title','Admin Profile')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if(!empty(Auth::User()->avatar_original))
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{url(Auth::User()->avatar_original)}}" alt="Admin profile picture">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{asset('uploads/profile/default.png')}}" alt="User profile picture">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{Auth::User()->name}}</h3>

                            <p class="text-muted text-center">{{Auth::User()->user_type}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Total Products</b> <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Orders</b> <a class="float-right">543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Sold Amount</b> <a class="float-right">13,287</a>
                                </li>
                            </ul>

                            {{--                            <a href="{{route('shop.details',$shopInfo->slug)}}" class="btn btn-primary btn-block"><b>Go To Shop</b></a>--}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                {{--                    <div class="card card-primary">--}}
                {{--                        <div class="card-header">--}}
                {{--                            <h3 class="card-title">About Shop</h3>--}}
                {{--                        </div>--}}
                {{--                        <!-- /.card-header -->--}}
                {{--                        <div class="card-body">--}}
                {{--                            <strong><i class="fas fa-book mr-1"></i> Description</strong>--}}

                {{--                            <p class="text-muted">--}}
                {{--                                {{$shopInfo->about}}--}}
                {{--                            </p>--}}
                {{--                        </div>--}}
                {{--                        <!-- /.card-body -->--}}
                {{--                    </div>--}}
                <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#seller_info" data-toggle="tab">Admin
                                        Info</a></li>
                                <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">Edit
                                        Profile </a></li>
                                <li class="nav-item"><a class="nav-link" href="#change_pass" data-toggle="tab">Change Password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="seller_info">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{Auth::User()->name}}" class="form-control" id="inputName" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="email" value="{{Auth::User()->phone}}" class="form-control" id="inputEmail" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" value="{{Auth::User()->email}}" class="form-control" id="inputEmail" readonly>
                                            </div>
                                        </div>
                                        {{--                                        <div class="form-group row">--}}
                                        {{--                                            <label for="inputEmail" class="col-sm-2 col-form-label">Shop Name</label>--}}
                                        {{--                                            <div class="col-sm-10">--}}
                                        {{--                                                <input type="email" value="{{$shopInfo->name}}" class="form-control" id="inputEmail" readonly>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{Auth::User()->address}}" class="form-control" id="address" readonly>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="edit">
                                    <form class="form-horizontal" action="{{route('admin.profile.update',Auth::User()->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{Auth::User()->name}}" name="name" class="form-control" id="inputName" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="number" value="{{Auth::User()->phone}}" name="phone" class="form-control" id="inputEmail" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" value="{{Auth::User()->email}}" name="email" class="form-control" id="inputEmail" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="change_pass">
                                    <form class="form-horizontal" action="{{route('admin.password.update',Auth::User()->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">New Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" class="form-control" id="inputName">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Confirm Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password_confirmation" class="form-control" id="inputEmail">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                {{--                    <div class="card">--}}
                {{--                        <div class="card-header  p-2 p-0 bg-info">--}}
                {{--                            <strong>Bank Details</strong>--}}
                {{--                        </div>--}}
                {{--                        <div class="card-body">--}}
                {{--                            <form class="form-horizontal" action="{{route('admin.seller.bankinfo.update',$sellerInfo->id)}}" method="POST">--}}
                {{--                                @csrf--}}
                {{--                                @method('PUT')--}}
                {{--                                <div class="form-group row">--}}
                {{--                                    <label for="inputName" class="col-sm-2 col-form-label">Bank Name</label>--}}
                {{--                                    <div class="col-sm-10">--}}
                {{--                                        <input type="test" name="bank_name" value="{{$sellerInfo->bank_name}}" class="form-control" id="inputName">--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="form-group row">--}}
                {{--                                    <label for="inputEmail" class="col-sm-2 col-form-label">Bank Acc Name</label>--}}
                {{--                                    <div class="col-sm-10">--}}
                {{--                                        <input type="text" name="bank_acc_name"  value="{{$sellerInfo->bank_acc_name}}" class="form-control" id="inputEmail">--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="form-group row">--}}
                {{--                                    <label for="bank_acc_no" class="col-sm-2 col-form-label">Bank Acc Number</label>--}}
                {{--                                    <div class="col-sm-10">--}}
                {{--                                        <input type="text" name="bank_acc_no" value="{{$sellerInfo->bank_acc_no}}" class="form-control" id="bank_acc_no">--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="form-group row">--}}
                {{--                                    <label for="inputName2" class="col-sm-2 col-form-label">Bank Routing Number</label>--}}
                {{--                                    <div class="col-sm-10">--}}
                {{--                                        <input type="number" name="bank_routing_no" value="{{$sellerInfo->bank_routing_no}}" class="form-control" id="inputName2" >--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="form-group row">--}}
                {{--                                    <div class="offset-sm-2 col-sm-10">--}}
                {{--                                        <button type="submit" class="btn btn-danger">Submit</button>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </form>--}}
                {{--                        </div><!-- /.card-body -->--}}
                {{--                    </div>--}}
                <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@stop
