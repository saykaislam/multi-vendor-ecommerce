@extends('frontend.layouts.master')
@section('title', 'Order Details')
@section('content')
    <main class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="">Account</a></li>
                    <li>Order Details</li>
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
                                    <h3>Invoice: <strong>{{$order->invoice_code}}</strong></h3>
                                </div>
                                <div class="ps-section__content">
                                    <h3>Product List</h3>
                                    <div class="table-responsive">
                                        <table class="table ps-table">
                                            <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Vat</th>
                                                <th>Labour Cost</th>
                                                <th>Total (৳)</th>
                                                <th>Review</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orderDetails as $key =>$orderDetail)
                                                @php
                                                $review = \App\Model\Review::where('order_id',$order->id)->where('user_id',$order->user_id)->where('product_id',$orderDetail->product_id)->first();
                                                @endphp
                                            <tr>
                                                <td>{{ $key +1 }}</td>
                                                <td>
                                                    <img src="{{url($orderDetail->product->thumbnail_img)}}" alt="" width="80" height="80">
                                                </td>
                                                <td>
                                                    {{$orderDetail->name}}
                                                </td>
                                                <td>{{$orderDetail->quantity}}</td>
                                                <td>{{$orderDetail->vat}}</td>
                                                <td>{{$orderDetail->labour_cost}}</td>
                                                <td><span>{{($orderDetail->price * $orderDetail->quantity) + $orderDetail->vat + $orderDetail->labour_cost}}</span></td>
                                                <td>
                                                    @if($order->delivery_status == 'Completed' && empty($review))
                                                        <a class="btn btn-default" data-toggle="modal" onclick="getProductId('{{$orderDetail->product_id}}')" data-target="#exampleModal" style="background: yellow;">
                                                            <i class="fa fa-star"></i></a>
                                                    @elseif(!empty($review))
                                                        <i title="Review submitted!" class="fa fa-check-square text-success text-bold"></i>
                                                    @else
                                                        <p>Order not Delivered yet</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
{{--                                            <tr>--}}
{{--                                                <td>--}}
{{--                                                    <div class="ps-product--cart">--}}
{{--                                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/6.jpg" alt=""></a></div>--}}
{{--                                                        <div class="ps-product__content"><a href="product-default.html">Sound Intone I65 Earphone White Version</a>--}}
{{--                                                            <p>Sold By:<strong> YOUNG SHOP</strong></p>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </td>--}}
{{--                                                <td><span><i>$</i> 100.99</span></td>--}}
{{--                                                <td>1</td>--}}
{{--                                                <td><span><i>$</i> 100.99</span></td>--}}
{{--                                            </tr>--}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Submit Your Review</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="ps-form--review" action="{{route('user.order.review.store')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" id="product_id">
                                                <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                                                <div class="modal-body">
                                                    {{--                                                    <h4>Submit Your Review</h4>--}}
                                                    <div class="form-group form-group__rating">
                                                        <label>Your rating of this product</label>
                                                        <select class="ps-rating" name="rating" data-read-only="false" required>
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="comment" rows="4" placeholder="Write your review here" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="form-group submit">
                                                        <button class="ps-btn">Submit Review</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="ps-section__footer"><a class="ps-btn ps-btn--sm" href="#">Back to invoices</a></div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('js')
    <script>
        function getProductId(productId){
            $('#product_id').val(productId);
            console.log(productId)
        }
    </script>
@endpush
