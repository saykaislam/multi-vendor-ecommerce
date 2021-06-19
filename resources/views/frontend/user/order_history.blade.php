@extends('frontend.layouts.master')
@section('title', 'Order History')
@push('css')
@endpush
@section('content')
    <main class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="">Account</a></li>
                    <li>Order History</li>
                </ul>
            </div>
        </div>
        <section class="ps-section--account">
            <div class="container">
                <div class="row">
                    @include('frontend.user.includes.user_sidebar')
                    <div class="col-lg-9">
                        <div class="ps-section__right">
                            <div class="ps-section--account-setting">
                                <div class="ps-section__header">
                                    <h3>Order History</h3>
                                </div>
                                <div class="ps-section__content">

                                    <div class="table-responsive">
                                        <table class="table ps-table ps-table--invoices">
                                            <thead>
                                            <tr>
                                                <th>#Id</th>
                                                <th>Invoice</th>
                                                <th>Date</th>
                                                <th>Discount</th>
                                                <th>Total Vat</th>
                                                <th>Total Labour Cost</th>
                                                <th>Grand Total</th>
                                                <th>Payment Status</th>
                                                <th>Delivery Status</th>
                                                <th>Print</th>
                                                <th>Details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orders as $key => $order)
                                            <tr>
                                                @php
                                                $review = \App\Model\Review::where('user_id',$order->user_id)->first();
                                                @endphp
                                                <td>{{$key + 1}}</td>
                                                <td>{{ $order->invoice_code }}</td>
                                                <td>{{date('j-m-Y',strtotime($order->created_at))}}</td>
                                                <td>{{ $order->discount }}</td>
                                                <td>{{ $order->total_vat }}</td>
                                                <td>{{ $order->total_labour_cost }}</td>
                                                <td>{{ $order->grand_total}}</td>
                                                <td>{{ $order->payment_status }}</td>
                                                <td>{{ $order->delivery_status }}</td>
                                                <td>
                                                    <a href="{{ route('invoice.print',encrypt($order->id)) }}" target="_blank" class="btn btn-default" style="background: green;"><i class="fa fa-print"></i></a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-info" href="{{route('user.order.details',encrypt($order->id))}}"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('js')
@endpush
