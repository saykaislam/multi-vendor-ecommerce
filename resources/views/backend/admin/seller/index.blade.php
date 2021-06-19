@extends('backend.layouts.master')
@section("title","Seller List")
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
                    <h1>Seller List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Seller List</li>
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
                                <h3 class="card-title float-left">Seller Lists</h3>
                            </div>
                            <div class="col-md-4">
                                <form action="" method="get">
                                    @csrf
                                    <div class="input-group float-center rounded">
                                        <input type="search" name="searchName" id="searchMain" class="form-control rounded" placeholder="Search Seller by Area" aria-label="Search"
                                               aria-describedby="search-addon" />
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <a href="{{route('admin.all-seller-excel.export')}}">
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
                                <th>Seller Name</th>
                                <th>Shop Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Area</th>
                                <th>Approval</th>
                                <th>Commission</th>
                                <th>Num. of Products</th>
                                <th>Due to seller</th>
                                <th>Due to Admin</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($shops == null)
                                @foreach($sellerUserInfos as $key => $sellerUserInfo)
                                    <tr>
                                        <td>
                                            {{$key + 1}}
                                        </td>
                                        <td>
                                            {{$sellerUserInfo->name}}
                                            @if($sellerUserInfo->view == 0)
                                                <span class="right badge badge-danger">New</span>
                                            @endif
                                        </td>
                                        <td>{{$sellerUserInfo->shop->name}}</td>
                                        <td>{{$sellerUserInfo->phone}}</td>
                                        <td>{{$sellerUserInfo->email}}</td>
                                        <td>
                                            @if(!empty($sellerUserInfo->shop->area))
                                                {{$sellerUserInfo->shop->area}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($sellerUserInfo->banned == 0)
                                                <div class="form-group col-md-2">
                                                    <label class="switch" style="margin-top:40px;">
                                                        <input onchange="verification_status(this)" value="{{$sellerUserInfo->seller->id }}" {{$sellerUserInfo->seller->verification_status == 1? 'checked':''}} type="checkbox" >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            @else
                                                <strong class="badge badge-danger w-100">Banned</strong>
                                            @endif
                                        </td>
                                        <td ><strong class="badge badge-info w-100">{{$sellerUserInfo->seller->commission}}%</strong></td>
                                        <td>{{$sellerUserInfo->products->count()}}</td>
                                        <td>{{$sellerUserInfo->seller->admin_to_pay}}</td>
                                        <td>{{$sellerUserInfo->seller->seller_will_pay_admin}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="bg-dark dropdown-item" href="{{route('admin.seller.profile.show',encrypt($sellerUserInfo->id))}}">
                                                        <i class="fa fa-user"></i> Profile
                                                    </a>
                                                    <a class="bg-success dropdown-item" onclick="show_seller_payment_modal('{{$sellerUserInfo->seller->id}}');" href="#">
                                                        <i class="fa fa-money"></i> Pay To Seller
                                                    </a>
                                                    <a class="bg-primary dropdown-item" onclick="show_admin_payment_modal('{{$sellerUserInfo->seller->id}}');" href="#">
                                                        <i class="fa fa-money"></i> Pay To Admin
                                                    </a>
                                                    <a class="bg-warning dropdown-item" onclick="show_seller_commission_modal('{{$sellerUserInfo->seller->id}}');" href="#">
                                                        <i class="fa fa-money-bill-wave"></i> Set Commission
                                                    </a>
                                                    <a class="bg-secondary dropdown-item" href="{{route('admin.seller.payment.history',$sellerUserInfo->id)}}">
                                                        <i class="fa fa-history"></i> Payment History
                                                    </a>
                                                    {{--                                            <a class="bg-info dropdown-item" href="{{route('admin.sellers.edit',$sellerUserInfo->id)}}">--}}
                                                    {{--                                                <i class="fa fa-edit"></i> Edit--}}
                                                    {{--                                            </a>--}}
                                                    <a class="bg-danger dropdown-item" href="{{route('admin.sellers.ban',$sellerUserInfo->id)}}">
                                                        <i class="fa fa-ban"></i> Ban this seller
                                                    </a>

                                                    {{--                                            <button class="bg-danger dropdown-item" type="button"--}}
                                                    {{--                                                    onclick="deleteProduct({{$sellerUserInfo->id}})">--}}
                                                    {{--                                                <i class="fa fa-ban"></i> Ban this seller--}}
                                                    {{--                                            </button>--}}
                                                    {{--                                            <form id="delete-form-{{$sellerUserInfo->id}}" action="{{route('admin.sellers.destroy',$sellerUserInfo->id)}}" method="POST" style="display: none;">--}}
                                                    {{--                                                @csrf--}}
                                                    {{--                                                @method('DELETE')--}}
                                                    {{--                                            </form>--}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach($shops as $key => $shop)
                                    @php
                                        $sellerUserInfo = $shop->user;
                                    @endphp
                                    @if($sellerUserInfo->verification_code != null)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>
                                                {{$sellerUserInfo->name}}
                                                @if($sellerUserInfo->view == 0)
                                                    <span class="right badge badge-danger">New</span>
                                                @endif
                                            </td>
                                            <td>{{$shop->name}}</td>
                                            <td>{{$sellerUserInfo->phone}}</td>
                                            <td>{{$sellerUserInfo->email}}</td>
                                            <td>
                                                @if(!empty($sellerUserInfo->shop->area))
                                                    {{$sellerUserInfo->shop->area}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($sellerUserInfo->banned == 0)
                                                    <div class="form-group col-md-2">
                                                        <label class="switch" style="margin-top:40px;">
                                                            <input onchange="verification_status(this)" value="{{$sellerUserInfo->seller->id }}" {{$sellerUserInfo->seller->verification_status == 1? 'checked':''}} type="checkbox" >
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                @else
                                                    <strong class="badge badge-danger w-100">Banned</strong>
                                                @endif
                                            </td>
                                            <td ><strong class="badge badge-info w-100">{{$sellerUserInfo->seller->commission}}%</strong></td>
                                            <td>{{$sellerUserInfo->products->count()}}</td>
                                            <td>{{$sellerUserInfo->seller->admin_to_pay}}</td>
                                            <td>{{$sellerUserInfo->seller->seller_will_pay_admin}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="bg-dark dropdown-item" href="{{route('admin.seller.profile.show',encrypt($sellerUserInfo->id))}}">
                                                            <i class="fa fa-user"></i> Profile
                                                        </a>
                                                        <a class="bg-success dropdown-item" onclick="show_seller_payment_modal('{{$sellerUserInfo->seller->id}}');" href="#">
                                                            <i class="fa fa-money"></i> Pay To Seller
                                                        </a>
                                                        <a class="bg-primary dropdown-item" onclick="show_admin_payment_modal('{{$sellerUserInfo->seller->id}}');" href="#">
                                                            <i class="fa fa-money"></i> Pay To Admin
                                                        </a>
                                                        <a class="bg-warning dropdown-item" onclick="show_seller_commission_modal('{{$sellerUserInfo->seller->id}}');" href="#">
                                                            <i class="fa fa-money-bill-wave"></i> Set Commission
                                                        </a>
                                                        <a class="bg-secondary dropdown-item" href="{{route('admin.seller.payment.history',$sellerUserInfo->id)}}">
                                                            <i class="fa fa-history"></i> Payment History
                                                        </a>
                                                        <a class="bg-danger dropdown-item" href="{{route('admin.sellers.ban',$sellerUserInfo->id)}}">
                                                            <i class="fa fa-ban"></i> Ban this seller
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Seller Name</th>
                                <th>Shop Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Area</th>
                                <th>Approval</th>
                                <th>Commission</th>
                                <th>Num. of Products</th>
                                <th>Due to seller</th>
                                <th>Due to Admin</th>
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

        function verification_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('admin.seller.verification') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    //toastr.success('success', 'Todays Deal updated successfully');
                }
                else{
                    //toastr.danger('danger', 'Something went wrong');
                }
            });
        }
        function show_seller_payment_modal(id){
            $.post('{{ route('admin.sellers.payment_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#payment_modal #modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});

            });
        }
        function show_admin_payment_modal(id){
            $.post('{{ route('admin.payment_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#payment_modal #modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});

            });
        }
        function show_seller_commission_modal(id){
            $.post('{{ route('admin.sellers.commission_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#payment_modal #modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});

            });
        }

        jQuery(document).ready(function($) {
            var shop = new Bloodhound({
                remote: {
                    url: '/admin/search/area?q=%QUERY%',
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
                            return '<a href="/admin/seller/'+data.area+'" class="list-group-item custom-list-group-item">'+data.area+'</a>'
                        }
                    }
                },
            );
        });

    </script>
@endpush
