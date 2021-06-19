@extends('backend.layouts.master')
@section("title","Settings")
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{strtoupper('Settings' )}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-rocket"></i></span>
                        <a href="#" onclick="configCache()">
                            <div class="info-box-content">
                                <h4 class="info-box-text mt-1">Site Optimise</h4>
                            </div>
                        </a>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fa fa-plane"></i></span>
                        <a href="{{route('admin.cache.clear')}}">
                            <div class="info-box-content">
                                <h4 class="info-box-text mt-1">Site Cache Clear</h4>
                            </div>
                        </a>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fa fa-eye"></i></span>
                        <a href="{{route('admin.view.cache')}}">
                            <div class="info-box-content">
                                <h4 class="info-box-text mt-1">View Cache</h4>
                            </div>
                        </a>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1">
                            <i class="fa fa-eye"></i></span>
                        <a href="{{route('admin.view.clear')}}">
                            <div class="info-box-content">
                                <h4 class="info-box-text mt-1">View Clear</h4>
                            </div>
                        </a>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-dark elevation-1">
                            <i class="fa fa-road"></i></span>
                        <a href="{{route('admin.route.clear')}}">
                            <div class="info-box-content">
                                <h4 class="info-box-text mt-1">Route Clear</h4>
                            </div>
                        </a>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
               {{-- <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1">
                            <i class="fa fa-road"></i></span>
                        <a href="{{route('admin.route.cache')}}">
                            <div class="info-box-content">
                                <h4 class="info-box-text mt-1">Route Cache</h4>
                            </div>
                        </a>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>--}}
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@stop
@push('js')
    <script>
        function configCache(){
            $.ajax({
                url: "{{url('/admin/config-cache')}}",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    console.log(res);
                   toastr.success('Site Successfully Optimized');
                }
            });
        }

    </script>
@endpush
