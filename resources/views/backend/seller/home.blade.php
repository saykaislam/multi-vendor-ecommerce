@extends('backend.seller.layouts.master')
@section("title","Dashboard")
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{strtoupper('Seller Dashboard')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if(Auth::user()->seller->verification_status == 1)
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                @if(Auth::user()->referral_code !=null)
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner text-center">
                            <h4>{{Auth::user()->referral_code}}</h4>

                            <p>Refferal Code</p>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="" value="{{route('registration.refer.code',Auth::user()->referral_code)}}" id="myInput" aria-label="Recipient's username" aria-describedby="basic-addon2" data-toggle="tooltip" title="Click here to copy link!" style="height: 35px; padding: 0 10px">
                            <div class="input-group-append">
                                <button class="btn btn-success" onclick="copyToClipboard()">Copy Link</button>
                                {{--                    <span class="input-group-text bg-info" style="color: #ffffff"><a onclick="copyToClipboard()">Share</a></span>--}}
                            </div>
                        </div>

                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
{{--                        <a href="{{route('registration.refer.code',Auth::user()->referral_code)}}" class="small-box-footer" onclick="copyToClipboard()">Copy Link <i class="fas fa-arrow-circle-right"></i></a>--}}
                    </div>
                </div>
                @endif
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner text-center">
                            <h4>{{$totalProducts}}</h4>

                            <p>Products</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="{{route('seller.products.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner text-center">
                            <h4>{{$totalSales}}</h4>

                            <p>Total Sale</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner text-center">
                            <h4>{{$totalEarning}}</h4>

                            <p>Total Earnings</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner text-center">
                            <h4>{{$totalCompletedOrders}}</h4>
                            <p>Successful Orders</p>

                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{route('seller.order.completed')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <!-- Left col -->
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Orders
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>Total Orders:</th>
                                    <td>{{$totalOrders}}</td>

                                </tr>
                                <tr>
                                    <th>Pending Orders:</th>
                                    <td>{{$totalPendingOrders}}</td>

                                </tr>
                                <tr>
                                    <th>Cancelled Orders:</th>
                                    <td>{{$totalCancelOrders}}</td>

                                </tr>
                                <tr>
                                    <th>Successful Orders:</th>
                                    <td>{{$totalCompletedOrders}}</td>

                                </tr>
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div>
                </section>
            <section class="col-lg-3 connectedSortable">

                <!-- Map card -->
                <div class="card " >
                    <div class="card-header border-0">
                       <a class="card-img" href="">
                        <img src="{{asset('uploads/profile/approved.jpg')}}" class="card-img-top" alt="..." width="150" height="160">
                       </a>

                    </div>
                    <div class="card-body text-center">
{{--                        <a href="#" class="btn btn-primary ">Verify Now</a>--}}
                    </div>
                    <!-- /.card-body-->
                    <div class="card-footer bg-transparent">
                        <div class="row">

                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </section>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner text-center">
                        <h4>{{$adminCommission}}</h4>
                        <p>Admin get commission</p>

                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @else
        <section class="col-lg-3 connectedSortable" style="margin-left: 350px; margin-top: 50px;">
            <img src="{{asset('uploads/profile/not-verified.png')}}" class="card-img-top" alt="..." width="100" height="200">


            <!-- Map card -->
{{--            <div class="card " >--}}
{{--                <div class="card-header border-0">--}}
{{--                    <a class="card-img" href="">--}}
{{--                        <img src="{{asset('uploads/profile/not-verified.png')}}" class="card-img-top" alt="..." width="150" height="160">--}}
{{--                    </a>--}}

{{--                </div>--}}
{{--                <div class="card-body text-center">--}}
{{--                    <a href="#" class="btn btn-primary ">Verify Now</a>--}}
{{--                </div>--}}
{{--                <!-- /.card-body-->--}}
{{--                <div class="card-footer bg-transparent">--}}
{{--                    <div class="row">--}}

{{--                        <!-- ./col -->--}}
{{--                    </div>--}}
{{--                    <!-- /.row -->--}}
{{--                </div>--}}
{{--            </div>--}}
        </section>
    @endif


@stop
@push('js')
    <script>
        function copyToClipboard() {
            /* Get the text field */
            var copyText = document.getElementById("myInput");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            document.execCommand("copy");

            /* Alert the copied text */
            // alert("Referral Link successfully copied ");
            toastr.success('Referral Link successfully copied');
        }
    </script>
@endpush
