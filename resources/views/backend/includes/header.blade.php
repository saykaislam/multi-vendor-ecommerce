<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a target="_blank" href="{{url('/')}}" class="nav-link"  data-toggle="frontend" data-placement="bottom" data-original-title="Browse Frontend">
                <i class="fas fa-globe"></i>
            </a>
        </li>
        {{--<li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Profile</a>
        </li>--}}
    </ul>

    <!-- SEARCH FORM -->
{{--    <form class="form-inline ml-3">--}}
{{--        <div class="input-group input-group-sm">--}}
{{--            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
{{--            <div class="input-group-append">--}}
{{--                <button class="btn btn-navbar" type="submit">--}}
{{--                    <i class="fa fa-search"></i>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </form>--}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{asset('backend/dist/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{asset('backend/dist/img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{asset('backend/dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        @php
            $new_products_request = \App\Model\Product::where('added_by','seller')->where('admin_permission',0)->count();
                $new_orders = \App\Model\Order::where('delivery_status','Pending')->where('view',0)->count();
            $new_seller = \App\User::where('user_type','seller')->where('verification_code','!=',null)->where('view',0)->count();
            $new_customer = \App\User::where('user_type','customer')->where('verification_code','!=',null)->where('view',0)->count();
             $new_reviews = \App\Model\Review::where('viewed',0)->count();
        @endphp
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge">{{$new_products_request + $new_orders + $new_seller + $new_customer + $new_reviews}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{$new_products_request + $new_orders + $new_seller + $new_customer + $new_reviews}} Notifications</span>
                @if($new_products_request >0)
                    <div class="dropdown-divider"></div>
                    <a href="{{route('admin.products.request.form.seller')}}" class="dropdown-item">
                        <i class="fas fa-shopping-cart mr-2"></i>{{$new_products_request}} new Requested Product
                    </a>
                @endif
                @if($new_orders >0)
                    <div class="dropdown-divider"></div>
                    <a href="{{route('admin.order.pending')}}" class="dropdown-item">
                        <i class="fas fa-box mr-2"></i>{{$new_orders}} new Order
                    </a>
                @endif
                @if($new_seller >0)
                <div class="dropdown-divider"></div>
                <a href="{{route('admin.sellers.index')}}" class="dropdown-item">
                    <i class="fas fa-store mr-2"></i> {{$new_seller}} new Seller
                </a>
                @endif
                @if($new_customer >0)
                <div class="dropdown-divider"></div>
                <a href="{{route('admin.customers.index')}}" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> {{$new_customer}} new Customer
                </a>
                @endif
                @if($new_reviews >0)
                <div class="dropdown-divider"></div>
                <a href="{{route('admin.review.index')}}" class="dropdown-item">
                    <i class="fas fa-star mr-2"></i> {{$new_reviews}} new Review
                </a>
                @endif
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-user-circle"></i> <strong>{{Auth::user()->name}}</strong>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="image text-center">
                    <img src="{{asset('backend/images/logo.png')}}" width="60px" height="60px" class="img-circle elevation-2 mt-2" alt="User Image">
                </div>
                <span class="dropdown-item dropdown-header">
                    <strong>{{Auth::user()->name}}</strong><br>
                    <small>{{Auth::user()->created_at->diffForHumans()}}</small>
                </span>
                <div class="dropdown-divider"></div>
                <div class="float-left">
                    <a href="" class="dropdown-item">
                        <i class="fa fa-user-circle-o mr-2"></i> Profile
                    </a>
                </div>
                <div class="float-right">
                    <a href="#" class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out mr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                <div class="dropdown-divider"></div>
            </div>
        </li>
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i--}}
{{--                    class="fa fa-th-large"></i></a>--}}
{{--        </li>--}}
    </ul>
</nav>
