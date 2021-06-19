@extends('backend.layouts.master')
@section("title","Customer List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        .twitter-typeahead{
            width: 100% !important;
        }
        .tt-menu{
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Customer List</li>
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
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="card-title float-left">Customer Lists</h3>
                            </div>
                            <div class="col-md-4">
                                <form action="" method="get">
                                    @csrf
                                    <div class="input-group float-center rounded">
                                        <input type="search" name="searchName" id="searchMain" class="form-control rounded" placeholder="Search Customer by Area" aria-label="Search"
                                               aria-describedby="search-addon" />
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <a href="{{route('admin.all-customer-excel.export')}}">
                                        <button class="btn btn-info text-center" style="margin-left: 100px;">Excel Export</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($addresses == null)
                                @foreach($customerInfos as $key => $customerInfo)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>
                                            {{$customerInfo->name}}
                                            @if($customerInfo->view == 0)
                                                <span class="right badge badge-info">New</span>
                                            @elseif($customerInfo->banned == 1)
                                                <span class="right badge badge-danger">Banned</span>
                                            @endif
                                        </td>
                                        <td>{{$customerInfo->phone}}</td>
                                        <td>{{$customerInfo->email}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="bg-dark dropdown-item" href="{{route('admin.customers.profile.show',encrypt($customerInfo->id))}}">
                                                        <i class="fa fa-user"></i> Profile
                                                    </a>
                                                    <a class="bg-danger dropdown-item" href="{{route('admin.customers.ban',$customerInfo->id)}}">
                                                        <i class="fa fa-ban"></i> Ban this Customer
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach($addresses as $key => $address)
                                    @php
                                        $customerInfos = \App\User::where('id',$address->user_id)->latest()->get();
                                    @endphp
                                    @foreach($customerInfos as $customerInfo)
                                    <tr>
                                        <td>
                                            {{$key + 1}}
                                        </td>
                                        <td>
                                            {{$customerInfo->name}}
                                            @if($customerInfo->view == 0)
                                                <span class="right badge badge-info">New</span>
                                            @elseif($customerInfo->banned == 1)
                                                <span class="right badge badge-danger">Banned</span>
                                            @endif
                                        </td>
                                        <td>{{$customerInfo->phone}}</td>
                                        <td>{{$customerInfo->email}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="bg-dark dropdown-item" href="{{route('admin.customers.profile.show',encrypt($customerInfo->id))}}">
                                                        <i class="fa fa-user"></i> Profile
                                                    </a>
                                                    <a class="bg-danger dropdown-item" href="{{route('admin.customers.ban',$customerInfo->id)}}">
                                                        <i class="fa fa-ban"></i> Ban this Customer
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal html start--}}
        <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="modal-content">

                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
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

        jQuery(document).ready(function($) {
            var shop = new Bloodhound({
                remote: {
                    url: '/admin/customer/search/area?q=%QUERY%',
                    wildcard: '%QUERY%'
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace('searchName'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            $("#searchMain").typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                }, {
                    source: shop.ttAdapter(),
                    // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                    name: 'areaList',
                    display: 'area',
                    // the key from the array we want to display (name,id,email,etc...)
                    templates: {
                        empty: [
                            '<div class="list-group search-results-dropdown"><div class="list-group-item">Sorry,We could not find any Area.</div></div>'
                        ],
                        header: [
                            // '<div class="list-group search-results-dropdown"><div class="list-group-item custom-header">Product</div>'
                        ],
                        suggestion: function (data) {
                            return '<a href="/admin/customer/'+data.area+'" class="list-group-item custom-list-group-item">'+data.area+'</a>'
                        }
                    }
                },
            );
        });

    </script>
@endpush
