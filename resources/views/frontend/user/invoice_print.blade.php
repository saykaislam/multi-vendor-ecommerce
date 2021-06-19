<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mudi Hat | Invoice Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h2 class="page-header">
                    <img src="{{asset('frontend/img/logo-mudi-hat.png')}}">
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row ">

            <div class="col-sm-4 ">
                Company Info
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
            <div class="col-sm-4">
                Shipping Info
                <address>
                    <b>Name:</b> {{$shippingInfo->name}} <br>
                    <b>Phone: </b> {{$shippingInfo->phone}} <br>
                    <b>Email: </b> {{$shippingInfo->email}}<br>
                    <b>Address: </b> {{$shippingInfo->address}}<br>
                    @if(!empty($shippingInfo->postal_code))
                    <b>Postal Code: </b> {{$shippingInfo->postal_code}}<br>
                    @endif
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice Info</b><br>
                <b>Invoice Code:</b> {{$order->invoice_code}}<br>
                <b>Order ID:</b> {{$order->id}}<br>
                <b>Payment Due:</b> {{date('j-m-Y',strtotime($order->created_at))}}<br>
                <b>Transaction ID:</b> {{$order->transaction_id}}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        @php
        $orderDetails = \App\Model\OrderDetails::where('order_id',$order->id)->get();

        @endphp
        <div class="row" style="padding: 20px">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Product Variant</th>
                        <th>Payment Type</th>
                        <th>Qty</th>
                        <th>Vat</th>
                        <th>Labour Cost</th>
                        <th>Grand Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orderDetails as $key=>$orderDetail)

                        <tr>
                            <td>{{$key +1 }}</td>
                            <td>{{$orderDetail->name}}</td>
                            @if(!empty($orderDetail->productStock))
                                @php
                                    $name = explode('-', $orderDetail->productStock->variant);
                                @endphp
                                <td>
                                    @for($i = 0; $i< count($name); $i++ )
                                        {{$name[$i]}}
                                    @endfor
                                </td>
                            @else
                                <td><p>Empty</p></td>
                            @endif
                            <td>{{$orderDetail->order->payment_status}}</td>
                            <td>{{$orderDetail->quantity}}</td>
                            <td>{{$orderDetail->vat}}</td>
                            <td>{{$orderDetail->labour_cost}}</td>
                            <td>{{$orderDetail->price + $orderDetail->vat}}</td>
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
                {{--                <p class="lead">Payment Methods:</p>--}}
                {{--                <img src="../../dist/img/credit/visa.png" alt="Visa">--}}
                {{--                <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">--}}
                {{--                <img src="../../dist/img/credit/american-express.png" alt="American Express">--}}
                {{--                <img src="../../dist/img/credit/paypal2.png" alt="Paypal">--}}

                {{--                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">--}}
                {{--                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr--}}
                {{--                    jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.--}}
                {{--                </p>--}}
            </div>
            <!-- /.col -->
            <div class="col-6">
{{--                <p class="lead">Amount Due 2/22/2014</p>--}}

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>{{$order->grand_total}}</td>
                        </tr>
{{--                        <tr>--}}
{{--                            <th>Tax (9.3%)</th>--}}
{{--                            <td>$10.34</td>--}}
{{--                        </tr>--}}
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
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>
</body>
</html>
