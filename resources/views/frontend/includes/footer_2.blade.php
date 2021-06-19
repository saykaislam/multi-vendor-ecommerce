@php
    $quote = \App\Model\Quote::first();
@endphp


@if(Auth::check() && Auth::user()->user_type == 'customer' && Session::get('popup') != 1)
<div class="ps-popup" id="subscribe" data-time="500">
    <div class="ps-popup__content bg--cover" data-background="{{url($quote->image)}}" ><a class="ps-popup__close" href="#"><i class="icon-cross"></i></a>
        <form class="ps-form--subscribe-popup" action="" method="get">
            <div class="ps-form__content">
                <h4>Today's Quote</h4>
                @if(!empty($quote))
                <h2>{{$quote->title}}</h2>
                @endif

                <div class="ps-checkbox" style="padding-top: 10px;">
                    <input class="form-control popup" type="checkbox" id="not-show" name="not-show">
                    <label for="not-show">Don't show this popup again</label>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
<div id="back2top"><i class="icon icon-arrow-up"></i></div>
<div class="ps-site-overlay"></div>
<div id="loader-wrapper">
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<div class="ps-search" id="site-search"><a class="ps-btn--close" href="#"></a>
    <div class="ps-search__content">
        <form class="ps-form--primary-search" action="/" method="post">
            <input class="form-control" type="text" placeholder="Search for...">
            <button><i class="aroma-magnifying-glass"></i></button>
        </form>
    </div>
</div>
<div class="modal fade" id="product-quickview" tabindex="-1" role="dialog" aria-labelledby="product-quickview" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"><span class="modal-close" data-dismiss="modal"><i class="icon-cross2"></i></span>
            <article class="ps-product--detail ps-product--fullwidth ps-product--quickview">
                <div class="ps-product__header">
                    <div class="ps-product__thumbnail" data-vertical="false">
                        <div class="ps-product__images" data-arrow="true">
                            <div class="item"><img src="{{asset('frontend/img/products/detail/fullwidth/1.jpg')}}" alt=""></div>
                            <div class="item"><img src="{{asset('frontend/img/products/detail/fullwidth/2.jpg')}}" alt=""></div>
                            <div class="item"><img src="{{asset('frontend/img/products/detail/fullwidth/3.jpg')}}" alt=""></div>
                        </div>
                    </div>
                    <div class="ps-product__info">
                        <h1>Marshall Kilburn Portable Wireless Speaker</h1>
                        <div class="ps-product__meta">
                            <p>Brand:<a href="shop-default.html">Sony</a></p>
                            <div class="ps-product__rating">
                                <select class="ps-rating" data-read-only="true">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select><span>(1 review)</span>
                            </div>
                        </div>
                        <h4 class="ps-product__price">$36.78 – $56.99</h4>
                        <div class="ps-product__desc">
                            <p>Sold By:<a href="shop-default.html"><strong> Go Pro</strong></a></p>
                            <ul class="ps-list--dot">
                                <li> Unrestrained and portable active stereo speaker</li>
                                <li> Free from the confines of wires and chords</li>
                                <li> 20 hours of portable capabilities</li>
                                <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                            </ul>
                        </div>
                        <div class="ps-product__shopping"><a class="ps-btn ps-btn--black" href="#">Add to cart</a><a class="ps-btn" href="#">Buy Now</a>
                            <div class="ps-product__actions"><a href="#"><i class="icon-heart"></i></a><a href="#"><i class="icon-chart-bars"></i></a></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
@push('js')
    <script>

        /*$j(document).ready(function() {
            if(localStorage.getItem('popState') != 'shown'){
                $j("#popup").delay(2000).fadeIn();
                localStorage.setItem('popState','shown')
            }

            $j('#subscribe, #subscribe').click(function(e) // You are clicking the close button
            {
                $j('#subscribe').fadeOut(); // Now the pop up is hiden.
            });
        });*/

        //popup checked
        $('.popup').click(function() {
            console.log('sassssd')
            //alert($(this).attr('id'));  //-->this will alert id of checked checkbox.
            if(this.checked){
                $.ajax({
                    type: "GET",
                    url: '{{url('/popup-dataset')}}',
                    //data: $(this).attr('id'), //--> send id of checked checkbox on other page
                    success: function(data) {
                        document.location.reload();
                    },
                    // error: function() {
                    //     alert('it broke');
                    // },

                });

            }
        });

        //popup destroy
        $(window).unload(function(){
            $.ajax({
                type: "GET",
                url: '{{url('/popup-destroy')}}',
                //data: $(this).attr('id'), //--> send id of checked checkbox on other page
                success: function(data) {
                    alert(data);
                }
            });
        });
    </script>

@endpush
