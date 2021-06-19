@extends('backend.layouts.master')
@section("title","Seller Profile")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('backend/dist/css/spectrum.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/barikoi/barikoi-js@b6f6295467c19177a7d8b73ad4db136905e7cad6/dist/barikoi.min.css">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Seller Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Seller Profile</li>
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
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{url($userInfo->avatar_original)}}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{$userInfo->name}}</h3>

                            <p class="text-muted text-center">{{$userInfo->user_type}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Total Products</b> <a class="float-right">{{$totalProducts}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Orders</b> <a class="float-right">{{$totalOrders}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Sold Amount</b> <a class="float-right">{{$totalSoldAmount}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Wallet Balance</b> <a class="float-right">{{$userInfo->seller->admin_to_pay}}tk</a>
                                </li>
                            </ul>

                            <a href="{{route('shop.details',$shopInfo->slug)}}" class="btn btn-primary btn-block"><b>Go To Shop</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Shop</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Description</strong>

                            <p class="text-muted">
                                {{$shopInfo->about}}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#seller_info" data-toggle="tab">Seller
                                        Info</a></li>
                                <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">Edit
                                        Profile </a></li>
                                <li class="nav-item"><a class="nav-link" href="#change_pass" data-toggle="tab">Change Password</a></li>
                                <li class="nav-item"><a class="nav-link" href="#change_shop_address" data-toggle="tab">Change Shop Address</a></li>
                                <li class="nav-item"><a class="nav-link" href="#change_nid" data-toggle="tab">NID and Trade Licence</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="seller_info">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$userInfo->name}}" class="form-control" id="inputName" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="email" value="{{$userInfo->phone}}" class="form-control" id="inputEmail" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" value="{{$userInfo->email}}" class="form-control" id="inputEmail" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Shop Name</label>
                                            <div class="col-sm-10">
                                                <input type="email" value="{{$shopInfo->name}}" class="form-control" id="inputEmail" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Shop Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$shopInfo->address}}" class="form-control" id="address" readonly>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="edit">
                                    <form class="form-horizontal" action="{{route('admin.seller.profile.update',$userInfo->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$userInfo->name}}" name="name" class="form-control" id="inputName" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="number" value="{{$userInfo->phone}}" name="phone" class="form-control" id="inputEmail" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" value="{{$userInfo->email}}" name="email" class="form-control" id="inputEmail" >
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
                                    <form class="form-horizontal" action="{{route('admin.seller.password.update',$userInfo->id)}}" method="POST">
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
                                <div class="tab-pane" id="change_shop_address">
                                    <form class="form-horizontal" action="{{route('admin.seller.address.update',$userInfo->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Shop Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control bksearch {{ $errors->has('bksearch') ? ' is-invalid' : '' }}" value="{{ old('bksearch') }}" placeholder="Enter Your Shop Address" name="bksearch" required>
{{--                                               <input type="text" class="form-control bksearch {{ $errors->has('bksearch') ? ' is-invalid' : '' }}" value="{{ old('bksearch') }}" placeholder="Enter Your Shop Address" name="bksearch">--}}
                                            </div>
                                            <div class="bklist"></div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="address">
                                            <input type="hidden" name="city">
                                            <input type="hidden" name="area">
                                            <input type="hidden" name="latitude">
                                            <input type="hidden" name="longitude">
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <!-- .tab-pane -->
                                <div class="tab-pane" id="change_nid">
                                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="nid_number" class="col-sm-2 col-form-label">NID Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nid_number" id="nid_number" placeholder="NID Number Does Not Added Yet" value="{{$userInfo->seller->nid_number}}" {{$userInfo->seller->nid_number ? 'readonly' : ''}} required>
                                            </div>
                                        </div>
                                        @if(!empty($userInfo->seller->trade_licence_images))
                                        <div class="form-group row">
                                            <label class="control-label ml-3">Trade Licence Images</label>
                                            <div class="col-sm-10">
                                                <div class="row" id="trade_licence_images">
                                                    @if(is_array(json_decode($userInfo->seller->trade_licence_images)))
                                                        @foreach (json_decode($userInfo->seller->trade_licence_images) as $key => $photo)
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="img-upload-preview">
                                                                    <img loading="lazy"  src="{{url($photo)}}" alt="" class="img-responsive">
                                                                    <input type="hidden" name="previous_photos[]" value="{{url($photo)}}">
{{--                                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>--}}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                {{--                                    <div class="row" id="photos_alt"></div>--}}
                                            </div>
                                        </div>
                                        @endif
                                        {{--                                        <div class="form-group row">--}}
                                        {{--                                            <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>--}}
                                        {{--                                            <div class="col-sm-10">--}}
                                        {{--                                                <input type="password" name="password_confirmation" class="form-control">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="form-group row">
{{--                                            <div class="offset-sm-2 col-sm-10">--}}
{{--                                                <button type="submit" class="btn btn-danger">Update</button>--}}
{{--                                            </div>--}}
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header  p-2 p-0 bg-info">
                            <strong>Bank Details</strong>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{route('admin.seller.bankinfo.update',$sellerInfo->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Bank Name</label>
                                    <div class="col-sm-10">
                                        <input type="test" name="bank_name" value="{{$sellerInfo->bank_name}}" class="form-control" id="inputName">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Bank Acc Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="bank_acc_name"  value="{{$sellerInfo->bank_acc_name}}" class="form-control" id="inputEmail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bank_acc_no" class="col-sm-2 col-form-label">Bank Acc Number</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="bank_acc_no" value="{{$sellerInfo->bank_acc_no}}" class="form-control" id="bank_acc_no">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Bank Routing Number</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="bank_routing_no" value="{{$sellerInfo->bank_routing_no}}" class="form-control" id="inputName2" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/barikoi/barikoi-js@b6f6295467c19177a7d8b73ad4db136905e7cad6/dist/barikoi.min.js?key:MTg3NzpCRE5DQ01JSkgw"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

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
        $('.remove-files').on('click', function(){
            $(this).parents(".col-md-4").remove();
        });

    </script>

@endpush
