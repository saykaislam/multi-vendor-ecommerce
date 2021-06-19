@extends('backend.seller.layouts.master')
@section("title","Order Details")
@push('css')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
@endpush

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Order Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Order Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="callout callout-info">
                            <div class="card card-info" style="padding: 20px 40px 40px 40px;">
                                <div class="row">
                                        <div class="col-4">
                                            <label>Payment Status</label>
                                                <input type="text" value="{{$order->payment_status}}" class="form-control" id="inputName" readonly>
                                        </div>
                                        <div class="col-4">
                                            <form id="status-form-{{$order->id}}" action="{{route('seller.order-product.status',$order->id)}}">
                                                <label for="delivery_status">Change Delivery Status</label>
                                                <select name="delivery_status" class="form-control" onchange="deliveryStatusChange({{$order->id}})">
                                                    <option value="Pending" {{$order->delivery_status == 'Pending'? 'selected' : ''}}>Pending</option>
                                                    <option value="On review" {{$order->delivery_status == 'On review'? 'selected' : ''}}>On review</option>
                                                    <option value="On delivered" {{$order->delivery_status == 'On delivered'? 'selected' : ''}}>On delivered</option>
                                                    <option value="Delivered" {{$order->delivery_status == 'Delivered'? 'selected' : ''}}>Delivered</option>
                                                    <option value="Completed" {{$order->delivery_status == 'Completed'? 'selected' : ''}}>Completed</option>
                                                    <option value="Cancel" {{$order->delivery_status == 'Cancel'? 'selected' : ''}}>Cancel</option>
                                                </select>
                                            </form>
{{--                                            <label>Delivery Status</label>--}}
{{--                                            <input type="text" value="{{$order->delivery_status}}" class="form-control" id="inputName" readonly>--}}
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
{{--                            <div class="row">--}}
{{--                                <!-- /.col -->--}}
{{--                            </div>--}}
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <strong>Company Info</strong>
                                    <address>
                                        <strong>Mudi Hat</strong><br>
                                        <b>Address :</b> 5th Floor (Lift Button-4), BBTOA Building, 9 No South, Mirpur Rd, Dhaka 1207<br>
                                        <b>Phone :</b> (804) 123-5432<br>
                                        <b>Email :</b> info@mudihat.com<br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                @php
                                    $shippingInfo = json_decode($order->shipping_address)
                                @endphp
                                <div class="col-sm-4 invoice-col">
                                    <strong>Shipping Info</strong>
                                    <address>
                                        <b>Name:</b> {{$shippingInfo->name}} <br>
                                        <b>Phone: </b> {{$shippingInfo->phone}} <br>
                                        <b>Email: </b> {{$shippingInfo->email}}<br>
                                        <b>Address: </b> {{$shippingInfo->address}}<br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice Info</b><br>
{{--                                    <div class="code">Invoice Code: {{$orders->invoice_code}}</div><br>--}}
                                    <b>Invoice Code:</b> {{$order->invoice_code}}<br>
{{--                                    <b>Order ID:</b> {{$order->id}}<br>--}}
                                    <b>Date of Order:</b> {{date('jS F Y',strtotime($order->created_at))}}<br>
{{--                                    <b>Transaction ID:</b> {{$order->transaction_id}}--}}
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row" style="padding: 30px 0px 10px 0px;">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Payment Type</th>
                                            <th>QTY</th>
                                            <th>Vat</th>
                                            <th>Labour Cost</th>
                                            <th>Total</th>
                                            <th>Print</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orderDetails as $key=>$orderDetail)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>
                                                <img src="{{url($orderDetail->product->thumbnail_img)}}" width="100" height="80">
                                            </td>
                                            <td>{{$orderDetail->name}}</td>
                                            <td>{{$order->payment_status}}</td>
                                            <td>{{$orderDetail->quantity}}</td>
                                            <td>{{$orderDetail->vat}}</td>
                                            <td>{{$orderDetail->labour_cost}}</td>
                                            <td>{{($orderDetail->price * $orderDetail->quantity) + $orderDetail->vat + $orderDetail->labour_cost }}</td>
                                            <td>
                                                <a href="{{ route('invoice.print',encrypt($order->id)) }}" target="_blank" class="btn btn-default" style="background: green;"><i class="fa fa-print"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">
                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table class="table">
{{--                                            <tr>--}}
{{--                                                <th style="width:50%">Subtotal:</th>--}}
{{--                                                <td>{{$orders->grand_total}}</td>--}}
{{--                                            </tr>--}}
                                            <tr>
                                                <th>Total Vat:</th>
                                                <td>{{$order->total_vat}}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>{{$order->delivery_cost}}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Labour Cost:</th>
                                                <td>{{$order->total_labour_cost}}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount:</th>
                                                <td>{{$order->discount}}</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>{{$order->grand_total}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
@endsection
@push('js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
        $('#printInvoice').click(function(){
            Popup($('.invoice')[0].outerHTML);
            function Popup(data)
            {
                window.print();
                return true;
            }
        });
        //sweet alert
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
    </script>
@endpush
