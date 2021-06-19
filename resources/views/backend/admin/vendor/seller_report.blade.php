@extends('backend.layouts.master')
@section("title","Seller Order Report")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Seller Order Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Seller Order Report</li>
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
{{--                    <div class="card-header">--}}
{{--                        <h3 class="card-title float-left">Seller Order Report</h3>--}}
{{--                        <div class="float-right">--}}
{{--                            --}}{{--<a href="{{route('admin.p.create')}}">--}}
{{--                                <button class="btn btn-success">--}}
{{--                                    <i class="fa fa-plus-circle"></i>--}}
{{--                                    Add--}}
{{--                                </button>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="callout callout-info">
                        <div class="card card-info" style="padding: 20px 40px 40px 40px;">
                            <form role="form" action="{{route('admin.seller-order-details')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <label>Seller List</label>
                                        <select name="seller_id" id="" class="form-control select2">
                                            @foreach($sellers as $seller)
                                                @if($seller->seller->verification_status == 1)
                                                    <option value="{{$seller->id}}" {{$sellerId == $seller->id ? 'selected' : ''}}>{{$seller->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        {{--                                            <input type="text" class="form-control" placeholder="First name">--}}
                                    </div>
{{--                                    @dd($orders)--}}
                                    <div class="col-4">
                                        <label>Delivery Status</label>
                                        <select name="delivery_status" id="" class="form-control select2">
                                                <option value="Pending" {{$deliveryStatus == 'Pending' ? 'selected' : ''}}>Pending</option>
                                                <option value="On review" {{$deliveryStatus == 'On review' ? 'selected' : ''}}>On review</option>
                                                <option value="On delivered" {{$deliveryStatus == 'On delivered' ? 'selected' : ''}}>On delivered</option>
                                                <option value="Delivered" {{$deliveryStatus == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                                <option value="Completed" {{$deliveryStatus == 'Completed' ? 'selected' : ''}}>Completed</option>
                                                <option value="Cancel" {{$deliveryStatus == 'Cancel' ? 'selected' : ''}}>Cancel</option>
                                        </select>
                                    </div>
                                    <div class="col-4" style="margin-top: 30px">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        @if($orders != null)
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Date</th>
                                <th>Invoice Code</th>
                                <th>Payment Method</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{date('j-m-Y',strtotime($order->created_at))}}</td>
                                    <td>{{$order->invoice_code}}</td>
                                    <td>{{$order->payment_type}}</td>
                                    <td>
                                        <a class="btn btn-info waves-effect" href="{{route('admin.order-details',encrypt($order->id))}}">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Date</th>
                                <th>Invoice Code</th>
                                <th>Payment Method</th>
                                <th>Details</th>
                            </tr>
                            </tfoot>
                        </table>
                        @else
                            <div class="text-center ">
                                <h2><i class="fa fa-info-circle text-info"></i> Please Select Seller and delivery status!!!</h2>
                            </div>
                        @endif
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
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
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
    <script>
        //Initialize Select2 Elements
        $('.select2').select2();
        /*$('.textarea').wysihtml5({
            toolbar: { fa: true }
        })*/
    </script>
@endpush
