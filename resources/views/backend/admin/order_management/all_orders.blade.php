@extends('backend.layouts.master')
@section("title","All Orders List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
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
                    <h1>All Orders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">All Orders</li>
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
                                <h3 class="card-title float-left">All Orders</h3>
                            </div>
                            <div class="col-md-4">
                                <form action="" method="get">
                                    @csrf
                                    <div class="input-group float-center rounded" style="">
                                        <input type="search" name="searchName" id="searchMain" class="form-control rounded" placeholder="Search Orders by Area" aria-label="Search"
                                               aria-describedby="search-addon" />
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <a href="{{route('admin.all-order-excel.export')}}">
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
                                <th>#ID</th>
                                <th>Date</th>
                                <th>Invoice ID</th>
                                <th>Area</th>
                                <th>Payment Method</th>
                                <th>Grand Total</th>
                                <th>Discount</th>
                                <th>Total Vat</th>
                                <th title="Delivery Status">D.Status</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($areaWiseOrders == null)
                            @foreach($orders as $key=>$order)
                                <tr>
                                    <td>
                                        {{$key + 1}}
                                    </td>
                                    <td>
                                        {{date('j-m-Y',strtotime($order->created_at))}}
                                        @if($order->view == 0)
                                            <span class="right badge badge-danger">New</span>
                                        @endif
                                    </td>
                                    <td>{{$order->invoice_code}}</td>
                                    <td>{{$order->area}}</td>
                                    <td>{{$order->payment_type}}</td>
                                    <td>{{$order->grand_total }}</td>
                                    <td>{{$order->discount }}</td>
                                    <td>{{$order->total_vat }}</td>
                                    <td>
                                        <form id="status-form-{{$order->id}}" action="{{route('admin.order-product.status',$order->id)}}">
                                            <select name="delivery_status" id="" onchange="deliveryStatusChange({{$order->id}})">
                                                <option value="Pending" {{$order->delivery_status == 'Pending'? 'selected' : ''}}>Pending</option>
                                                <option value="On review" {{$order->delivery_status == 'On review'? 'selected' : ''}}>On review</option>
                                                <option value="On delivered" {{$order->delivery_status == 'On delivered'? 'selected' : ''}}>On delivered</option>
                                                <option value="Delivered" {{$order->delivery_status == 'Delivered'? 'selected' : ''}}>Delivered</option>
                                                <option value="Completed" {{$order->delivery_status == 'Completed'? 'selected' : ''}}>Completed</option>
                                                <option value="Cancel" {{$order->delivery_status == 'Cancel'? 'selected' : ''}}>Cancel</option>
                                            </select>
                                        </form>

                                    </td>
                                    <td>
                                        <a class="btn btn-info waves-effect" href="{{route('admin.order-details',encrypt($order->id))}}">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                @foreach($areaWiseOrders as $key=>$order)
                                    <tr>
                                        <td>
                                            {{$key + 1}}
                                            @if($order->view == 0)
                                                <span class="right badge badge-danger">New</span>
                                            @endif
                                        </td>
                                        <td>{{date('j-m-Y',strtotime($order->created_at))}}</td>
                                        <td>{{$order->invoice_code}}</td>
                                        <td>{{$order->area}}</td>
                                        <td>{{$order->payment_type}}</td>
                                        <td>{{$order->grand_total }}</td>
                                        <td>{{$order->discount }}</td>
                                        <td>{{$order->total_vat }}</td>
                                        <td>
                                            <form id="status-form-{{$order->id}}" action="{{route('admin.order-product.status',$order->id)}}">
                                                <select name="delivery_status" id="" onchange="deliveryStatusChange({{$order->id}})">
                                                    <option value="Pending" {{$order->delivery_status == 'Pending'? 'selected' : ''}}>Pending</option>
                                                    <option value="On review" {{$order->delivery_status == 'On review'? 'selected' : ''}}>On review</option>
                                                    <option value="On delivered" {{$order->delivery_status == 'On delivered'? 'selected' : ''}}>On delivered</option>
                                                    <option value="Delivered" {{$order->delivery_status == 'Delivered'? 'selected' : ''}}>Delivered</option>
                                                    <option value="Completed" {{$order->delivery_status == 'Completed'? 'selected' : ''}}>Completed</option>
                                                    <option value="Cancel" {{$order->delivery_status == 'Cancel'? 'selected' : ''}}>Cancel</option>
                                                </select>
                                            </form>

                                        </td>
                                        <td>
                                            <a class="btn btn-info waves-effect" href="{{route('admin.order-details',encrypt($order->id))}}">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#ID</th>
                                <th>Date</th>
                                <th>Invoice ID</th>
                                <th>Payment Method</th>
                                <th>Grand Total</th>
                                <th>Discount</th>
                                <th>Total Vat</th>
                                <th title="Delivery Status">D.Status</th>
                                <th>Details</th>
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
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
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
        function deliveryStatusChange(id) {
            swal({
                title: 'Are you sure to change Delivery Status?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('status-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your Data is save :)',
                        'error'
                    )
                }
            })
        }

        jQuery(document).ready(function($) {
            var shop = new Bloodhound({
                remote: {
                    url: '/admin/order/search/area?q=%QUERY%',
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
                            return '<a href="/admin/orders/'+data.area+'" class="list-group-item custom-list-group-item">'+data.area+'</a>'
                        }
                    }
                },
            );
        });
    </script>
@endpush
