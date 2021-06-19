<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #303641;  min-height: 600px!important;border-radius: 0px 25px 25px 0px;">
    <!-- Brand Logo -->
{{--<a href="#" class="brand-link">
    <img src="{{asset('backend/images/logo.png')}}" width="150" height="100" alt="Aamar Bazar" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    --}}{{--<span class="brand-text font-weight-light">Farazi Home Care</span>--}}{{--
</a>--}}
<!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-2 pl-2 mb-2 d-flex">
            <div class="">
                <img src="{{asset('frontend/img/logo-mudi-hat.png')}}" class="" alt="User Image" width="100%">
            </div>
        </div>

    @if (Auth::check()  && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')  )
        <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}"
                           class="nav-link {{Request::is('admin/dashboard') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/brands*')
                        || Request::is('admin/categories*')
                        || Request::is('admin/subcategories*')
                        || Request::is('admin/sub-subcategories*')
                        || Request::is('admin/products*')
                        || Request::is('admin/flash_deals*')
                        || Request::is('admin/offers*')
                        || Request::is('admin/request/products*')
                        || Request::is('admin/all/seller/products*')
                        || Request::is('admin/attributes*'))
                    ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Product Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.attributes.index')}}"
                                   class="nav-link {{Request::is('admin/attributes*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/attributes*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Attributes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.brands.index')}}"
                                   class="nav-link {{Request::is('admin/brands*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/brands*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Brands</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.categories.index')}}"
                                   class="nav-link {{Request::is('admin/categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.subcategories.index')}}"
                                   class="nav-link {{Request::is('admin/subcategories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/subcategories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Subcategories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.sub-subcategories.index')}}"
                                   class="nav-link {{Request::is('admin/sub-subcategories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/sub-subcategories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Sub Subcategories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.products.index')}}"
                                   class="nav-link {{Request::is('admin/products*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/products*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Products</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.flash_deals.index')}}" class="nav-link {{Request::is('admin/flash_deals*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/flash_deals*') ? 'folder-open':'bolt'}} nav-icon"></i>
                                    <p>Flash Deals</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.offers.index')}}"
                                   class="nav-link {{Request::is('admin/offers*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/offers*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Offer</p>
                                </a>
                            </li>
                            @php
                                $products = \App\Model\Product::where('added_by','seller')->where('admin_permission',0)->count();
                            @endphp
                            <li class="nav-item">
                                <a href="{{route('admin.products.request.form.seller')}}"
                                   class="nav-link {{Request::is('admin/request/products/from/seller*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/request/products/from/seller*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>
                                        Seller Req Products
                                        @if($products > 0)
                                            <span class="badge badge-danger"> {{$products}} New</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.all.seller.products')}}"
                                   class="nav-link {{Request::is('admin/all/seller/products*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/all/seller/products*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>All Seller Products</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @php
                        $new_orders = \App\Model\Order::where('delivery_status','Pending')->where('view',0)->count();
                    @endphp
                    <li class="nav-item has-treeview {{(Request::is('admin/order*')) || Request::is('admin/all-orders*') ? 'menu-open' : ''}}">
                        <a href="" class="nav-link {{Request::is('admin/order') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>
                                Order Management
                                @if(!empty($new_orders))
                                    <span class="badge badge-danger"> {{$new_orders}} New</span>
                                @endif
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.all.orders')}}"
                                   class="nav-link {{Request::is('admin/all-orders*') || Request::is('admin/orders*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/all-orders*') || Request::is('admin/orders*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>
                                        All Orders
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.order.pending')}}"
                                   class="nav-link {{Request::is('admin/order/pending*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/order/pending*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>
                                        Pending Order
                                        @if(!empty($new_orders))
                                            <span class="right badge badge-danger">New ({{$new_orders}})</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.order.on-reviewed')}}"
                                   class="nav-link {{Request::is('admin/order/on-reviewed*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/order/on-reviewed*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>On Reviewed Order</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.order.on-delivered')}}"
                                   class="nav-link {{Request::is('admin/order/on-delivered*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/order/on-delivered*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>On Delivered Order</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.order.delivered')}}"
                                   class="nav-link {{Request::is('admin/order/delivered*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/order/delivered*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Delivered Order</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.order.completed')}}"
                                   class="nav-link {{Request::is('admin/order/completed*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/order/completed*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Completed Order</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.order.canceled')}}"
                                   class="nav-link {{Request::is('admin/order/canceled*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/order/canceled*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Cancel Order</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.daily-orders')}}"
                                   class="nav-link {{Request::is('admin/order/daily-orders*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/order/daily-orders*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Daily Orders</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/roles*') || Request::is('admin/staffs*')) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Role & permission
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.staffs.index')}}"
                                   class="nav-link {{Request::is('admin/staffs*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/staffs*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Staff Manage</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.roles.index')}}"
                                   class="nav-link {{Request::is('admin/role*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/roles*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Role Manage</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{(Request::is('admin/profile*') ) ? 'menu-open' : '' || (Request::is('admin/payment*') ) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>
                                Admin
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.profile.index')}}"
                                   class="nav-link {{Request::is('admin/profile') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/profile') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.payment.history')}}"
                                   class="nav-link {{Request::is('admin/payment/history*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/payment/history*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Admin Payments History</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @php
                        $new_seller = \App\User::where('user_type','seller')->where('verification_code','!=',null)->where('view',0)->count();
                    @endphp
                    <li class="nav-item has-treeview {{(Request::is('admin/sellers*') || Request::is('admin/due-to-seller*') || Request::is('admin/due-to-admin*') ) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>
                                Sellers
                                @if(!empty($new_seller))
                                    <span class="badge badge-danger"> {{$new_seller}} New</span>
                                @endif
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.sellers.index')}}"
                                   class="nav-link {{Request::is('admin/sellers') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/sellers') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p> Seller List
                                        @if(!empty($new_seller))
                                            <span class="right badge badge-danger">New {{$new_seller}}</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.due-to-seller')}}"
                                   class="nav-link {{Request::is('admin/due-to-seller*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/due-to-seller*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p> Due to Seller </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.due-to-admin')}}"
                                   class="nav-link {{Request::is('admin/due-to-admin*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/due-to-admin*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p> Due to Admin </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.seller.withdraw.request')}}"
                                   class="nav-link {{Request::is('admin/sellers/withdraw/request*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/sellers/withdraw/request*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Seller Withdraw Requests</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.seller.payment.history')}}"
                                   class="nav-link {{Request::is('admin/sellers/payment/history*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/sellers/payment/history*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Seller Payments History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.seller.commission.form')}}"
                                   class="nav-link {{Request::is('admin/sellers/commission/form*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/sellers/commission/form*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Commission Settings</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @php
                        $new_customer = \App\User::where('user_type','customer')->where('verification_code','!=',null)->where('view',0)->count();
                    @endphp
                    <li class="nav-item has-treeview {{(Request::is('admin/customer*') ) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Customers
                                @if(!empty($new_customer))
                                    <span class="badge badge-danger"> {{$new_customer}} New</span>
                                @endif
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.customers.index')}}"
                                   class="nav-link {{Request::is('admin/customer*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/customer*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>
                                        Customer List
                                        @if(!empty($new_customer))
                                            <span class="right badge badge-danger">New {{$new_customer}} </span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @php
                        $reviews = \App\Model\Review::where('viewed',0)->count();
                    @endphp
                    <li class="nav-item has-treeview {{(Request::is('admin/review*') ) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-star"></i>
                            <p>
                                Reviews
                                @if(!empty($reviews))
                                    <span class="badge badge-danger">{{$reviews}} New</span>
                                @endif
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.review.index')}}"
                                   class="nav-link {{Request::is('admin/review*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/review* ') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>
                                        All Ratings
                                        @if(!empty($reviews))
                                            <span class="right badge badge-danger">New ({{$reviews}})</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item ">
                        <a href="{{route('admin.business.index')}}" class="nav-link {{Request::is('admin/business*')  ? 'active' : ''}}">

                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                Business Settings
                            </p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.blogs.index')}}" class="nav-link {{Request::is('admin/blogs*')  ? 'active' : ''}}">

                            <i class="nav-icon fas fa-newspaper-o"></i>
                            <p>
                                Blog
                            </p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.sliders.index')}}" class="nav-link {{Request::is('admin/sliders*')  ? 'active' : ''}}">

                            <i class="nav-icon fas fa-sliders"></i>
                            <p>
                                Sliders
                            </p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.quote.index')}}" class="nav-link {{Request::is('admin/quote*')  ? 'active' : ''}}">

                            <i class="nav-icon fa fa-quote-left"></i>
                            <p>
                                Quote
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.get-all-vendors.index')}}" class="nav-link {{Request::is('admin/get-all-vendors*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>
                                Get all Vendors In Map
                            </p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.seller-order-report')}}" class="nav-link {{Request::is('admin/seller-order-report*') ? 'active' : ''}}">
                            <i class="nav-icon fab fa-first-order"></i>
                            <p>
                                Seller Order Report
                            </p>
                        </a>
                    </li>
                    <li class="nav-item ">

                        <a href="{{route('admin.site.optimize')}}" class="nav-link {{Request::is('admin/site-optimize*') ? 'active' : ''}}">
                            <i class="nav-icon fa fa-cog"></i>
                            <p>
                               Site Optimize
                            </p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.top-rated-shop')}}" class="nav-link {{Request::is('admin/top-rated-shop*') ? 'active' : ''}}">
                            <i class="nav-icon fa fa-store"></i>
                            <p>
                                Top Rated Shops
                            </p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.top-customers')}}" class="nav-link {{Request::is('admin/top-customers*') ? 'active' : ''}}">
                            <i class="nav-icon fa fa-user-shield"></i>
                            <p>
                                Top Customers
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        @endif
    </div>
    <!-- /.sidebar -->
</aside>


