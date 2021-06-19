<div class="ps-layout__left">
   @php
   $shopCat = \App\Model\ShopCategory::where('shop_id',$shop->id)->latest()->get();
    @endphp
    <aside class="widget widget_shop">
        <h4 class="widget-title">Categories</h4>
        <ul class="ps-list--categories">
            @foreach($shopCat as $Cat)
                <li class="current-menu-item menu-item-has-children"><a href="#"> {{$Cat->category->name}} </a><span class="sub-toggle"><i class="fa fa-angle-down"></i></span>
                    @php
                        $subcategory = \App\Model\Subcategory::where('category_id',$Cat->category_id)->latest()->get();
                    @endphp
                    <ul class="sub-menu">
                        @foreach($subcategory as $subCat)
                            <li class="current-menu-item "><a href="{{url('/products/'.$shop->slug.'/'.$Cat->category->slug.'/'.$subCat->slug)}}">{{$subCat->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </aside>
    <aside class="widget widget_shop">
        <h4 class="widget-title">BY BRANDS</h4>
        <form class="ps-form--widget-search" action="http://nouthemes.net/html/martfury/do_action" method="get">
            <input class="form-control" type="text" placeholder="">
            <button><i class="icon-magnifier"></i></button>
        </form>
        <figure class="ps-custom-scrollbar" data-height="250">
            @foreach($shopBrand as $Brand)
                <div class="ps-checkbox">
                    <input class="form-control" type="checkbox" id="{{$Brand->brand_id}}" name="brand">
                    <label for="{{$Brand->brand_id}}">{{$Brand->brand->name}}</label>
                </div>
            @endforeach
        </figure>
        <figure>
            <h4 class="widget-title">By Price</h4>
            <div id="nonlinear"></div>
            <p class="ps-slider__meta">Price:<span class="ps-slider__value">৳<span class="ps-slider__min"></span></span>-<span class="ps-slider__value">৳<span class="ps-slider__max"></span></span></p>
        </figure>
    </aside>
</div>
