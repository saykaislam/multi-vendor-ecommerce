@if($products->count() > 0)
    @foreach($products as $product)
        @php
            $flash_deal_product = \App\Model\FlashDealProduct::where('flash_deal_id', $flash_id)->where('product_id', $product->id)->first();
        @endphp
        <option value="{{$product->id}}" <?php if($flash_deal_product != null) echo "selected";?> >{{$product->name}}</option>
    @endforeach
@else
@endif