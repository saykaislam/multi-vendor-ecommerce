@extends('backend.layouts.master')
@section("title","Top Rated Shop List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 0px 6px!important;
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Top Rated Shop List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Shop List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Shop Lists</h3>
                        <div class="float-right">
{{--                            <a href="{{route('admin.categories.create')}}">--}}
{{--                                <button class="btn btn-success">--}}
{{--                                    <i class="fa fa-plus-circle"></i>--}}
{{--                                    Add--}}
{{--                                </button>--}}
{{--                            </a>--}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Name</th>
                                <th>Ratting</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reviews as $key => $review)
                                @php
                                    $shop = \App\Model\Shop::where('id',$review->shop_id)->first();
          $fiveStarRev = \App\Model\Review::where('shop_id',$shop->id)->where('rating',5)->where('status',1)->sum('rating');
          $fourStarRev = \App\Model\Review::where('shop_id',$shop->id)->where('rating',4)->where('status',1)->sum('rating');
          $threeStarRev = \App\Model\Review::where('shop_id',$shop->id)->where('rating',3)->where('status',1)->sum('rating');
          $twoStarRev = \App\Model\Review::where('shop_id',$shop->id)->where('rating',2)->where('status',1)->sum('rating');
          $oneStarRev = \App\Model\Review::where('shop_id',$shop->id)->where('rating',1)->where('status',1)->sum('rating');
          $rating = (5*$fiveStarRev + 4*$fourStarRev + 3*$threeStarRev + 2*$twoStarRev + 1*$oneStarRev) / ($review->total_rating);
                                @endphp
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                       <a href="{{route('shop.details',$shop->slug)}}">{{$shop->name}}</a>
                                    </td>
                                    <td>
                                        {{$totalRatingCount = number_format((float)$rating, 1, '.', '')}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Name</th>
                                <th>Ratting</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
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
    </script>
@endpush
