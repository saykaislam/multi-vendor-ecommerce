<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/login', 'Admin\AuthController@ShowLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\AuthController@LoginCheck')->name('admin.login.check');
Route::group(['as'=>'admin.','prefix' =>'admin','namespace'=>'Admin', 'middleware' => ['auth', 'admin']], function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::resource('roles','RoleController');
    Route::post('/roles/permission','RoleController@create_permission');
    Route::resource('staffs','StaffController');
    Route::resource('brands','BrandController');
    Route::resource('categories','CategoryController');
    Route::post('categories/is_home', 'CategoryController@updateIsHome')->name('categories.is_home');
    Route::resource('attributes','AttributeController');
    Route::resource('subcategories','SubcategoryController');
    Route::resource('sub-subcategories','SubSubcategoryController');
    Route::resource('products','ProductController');
    Route::resource('offers','OfferController');
//flash sales start
    Route::resource('flash_deals','FlashDealController');
    Route::get('/flash_deals/products/add/{flush_id}', 'FlashDealController@productsAdd')->name('flash_deals.products.add');
    Route::get('/flash_deals/products/edit/{flush_id}', 'FlashDealController@productsEdit')->name('flash_deals.products.edit');
    Route::post('/flash_deals/products/store', 'FlashDealController@flashDealProductsStore')->name('flash_deals.products.store');
    Route::get('/flash_deals/shop/products/{id}', 'FlashDealController@shopProducts')->name('flash_deals.shop.products');
    Route::get('/flash_deals/shop/products/edit/{id}/{flush_id}', 'FlashDealController@shopProductsEdit')->name('flash_deals.shop.products.edit');
    Route::post('/flash_deals/update_status', 'FlashDealController@update_status')->name('flash_deals.update_status');
    Route::post('/flash_deals/update_featured', 'FlashDealController@update_featured')->name('flash_deals.update_featured');
    Route::post('/flash_deals/product_discount', 'FlashDealController@product_discount')->name('flash_deals.product_discount');
    Route::post('/flash_deals/product_discount_edit', 'FlashDealController@product_discount_edit')->name('flash_deals.product_discount_edit');
    Route::post('/flash_deals/shop/wise/update', 'FlashDealController@flashDealProductsUpdate')->name('flash_deals.shop.wise.products.update');
//flash sales end
    Route::post('products/update2/{id}','ProductController@update2')->name('products.update2');
    Route::get('products/slug/{name}','ProductController@ajaxSlugMake')->name('products.slug');
    Route::post('products/get-subcategories-by-category','ProductController@ajaxSubCat')->name('products.get_subcategories_by_category');
    Route::post('products/get-subsubcategories-by-subcategory','ProductController@ajaxSubSubCat')->name('products.get_subsubcategories_by_subcategory');
    Route::post('products/sku_combination','ProductController@sku_combination')->name('products.sku_combination');
    Route::post('/products/sku_combination_edit', 'ProductController@sku_combination_edit')->name('products.sku_combination_edit');
    Route::post('products/todays_deal', 'ProductController@updateTodaysDeal')->name('products.todays_deal');
    Route::post('products/published/update', 'ProductController@updatePublished')->name('products.published');
    Route::post('products/featured/update', 'ProductController@updateFeatured')->name('products.featured');
    Route::get('/request/products/from/seller', 'ProductController@sellerReqList')->name('products.request.form.seller');
    Route::get('/all/seller/products/', 'ProductController@sellerProductList')->name('all.seller.products');
    Route::get('/all/seller/products/edit/{id}', 'ProductController@sellerProductEdit')->name('edit.seller.products');
    Route::post('/all/seller/products/update/{id}', 'ProductController@sellerProductUpdate')->name('update.seller.products');
    Route::post('ckeditor/upload', 'CkeditorController@upload')->name('ckeditor.upload');
    Route::resource('sellers','SellerController');
    Route::post('sellers/verification','SellerController@verification')->name('seller.verification');
    Route::get('sellers/commission/form','SellerController@commissionForm')->name('seller.commission.form');
    Route::put('sellers/commission/update/{id}','SellerController@commissionStore')->name('seller.commission.update');
    Route::get('sellers/payment/history','SellerController@paymentHistory')->name('seller.payment.history');
    Route::get('payment/history','SellerController@adminPaymentHistory')->name('payment.history');
    Route::get('payment/report/{id}','SellerController@adminPaymentReport')->name('payment.report');
    Route::get('sellers/withdraw/request','SellerController@withdrawRequest')->name('seller.withdraw.request');
    Route::get('sellers/profile/show/{id}','SellerController@profileShow')->name('seller.profile.show');
    Route::put('sellers/profile/update/{id}','SellerController@updateProfile')->name('seller.profile.update');
    Route::put('sellers/password/update/{id}','SellerController@updatePassword')->name('seller.password.update');
    Route::put('sellers/address/update/{id}','SellerController@updateAddress')->name('seller.address.update');
    Route::put('sellers/bankinfo/update/{id}','SellerController@bankInfoUpdate')->name('seller.bankinfo.update');
    Route::post('/sellers/payment_modal', 'SellerController@payment_modal')->name('sellers.payment_modal');
    Route::post('/payment_modal', 'SellerController@admin_payment_modal')->name('payment_modal');
    Route::post('/sellers/withdraw_payment_modal', 'SellerController@withdraw_payment_modal')->name('sellers.withdraw_payment_modal');
    Route::post('/sellers/commission_modal', 'SellerController@commission_modal')->name('sellers.commission_modal');
    Route::put('/sellers/individual/commission/set/{id}', 'SellerController@individulCommissionSet')->name('seller.individual.commission.set');
    Route::post('/sellers/pay_to_seller_commission', 'SellerController@pay_to_seller_commission')->name('seller.commissions.pay_to_seller');
    Route::post('/widthdraw-request/store/{id}', 'SellerController@admin_withdraw_store')->name('withdraw-request.store');
    Route::get('/sellers/ban/{id}','SellerController@banSeller')->name('sellers.ban');
    Route::get('/search/area', 'SellerController@search_area');
    Route::get('/seller/{area}','SellerController@areaWiseSeller')->name('area-wise.seller');



// Admin Order Management
    Route::get('all-orders','OrderManagementController@index')->name('all.orders');
    Route::get('order/pending','OrderManagementController@pendingOrder')->name('order.pending');
    Route::get('order/on-reviewed','OrderManagementController@onReviewedOrder')->name('order.on-reviewed');
    Route::get('order/on-delivered','OrderManagementController@onDeliveredOrder')->name('order.on-delivered');
    Route::get('order/delivered','OrderManagementController@deliveredOrder')->name('order.delivered');
    Route::get('order/completed','OrderManagementController@completedOrder')->name('order.completed');
    Route::get('order/canceled','OrderManagementController@canceledOrder')->name('order.canceled');
    Route::get('order-product/status-change/{id}','OrderManagementController@OrderProductChangeStatus')->name('order-product.status');
    Route::get('order-details/{id}','OrderManagementController@orderDetails')->name('order-details');
    Route::get('order-details/invoice/print/{id}','OrderManagementController@orderInvoicePrint')->name('invoice.print');
    Route::get('order/daily-orders','OrderManagementController@dailyOrders')->name('daily-orders');
    Route::get('order/search/area', 'OrderManagementController@search_area');
    Route::get('/orders/{area}','OrderManagementController@areaWiseOrder');


    //Admin Excel Export
    Route::get('/seller-product-export','ExportExcelController@exportSellerProducts')->name('seller-product-excel.export');
    Route::get('/all-order-export','ExportExcelController@exportOrders')->name('all-order-excel.export');
    Route::get('/all-seller-export','ExportExcelController@exportSeller')->name('all-seller-excel.export');
    Route::get('/all-customer-export','ExportExcelController@exportCustomer')->name('all-customer-excel.export');




    // Admin User Management
    Route::resource('customers','CustomerController');
    Route::get('customers/show/profile/{id}','CustomerController@profileShow')->name('customers.profile.show');
    Route::put('customers/update/profile/{id}','CustomerController@updateProfile')->name('customer.profile.update');
    Route::put('customers/password/update/{id}','CustomerController@updatePassword')->name('customer.password.update');
    Route::get('/customer/search/area', 'CustomerController@search_area');
    Route::get('/customer/{area}','CustomerController@areaWiseCustomer')->name('area-wise.customer');
    Route::get('/customer/ban/{id}','CustomerController@banCustomer')->name('customers.ban');

    //review
    Route::get('review','ReviewController@index')->name('review.index');
    Route::post('review/details', 'ReviewController@reviewDetails')->name('review.details');
    Route::post('review/status', 'ReviewController@updateStatus')->name('review.status');
    Route::get('review/view/{id}','ReviewController@view')->name('review.view');
    Route::post('review/update/{id}','ReviewController@reviewUpdate')->name('review.update');

    //Sliders
    Route::resource('sliders','SliderController');
    Route::resource('quote','QuoteController');

    //Blogs
    Route::resource('blogs','BlogController');

    //Business Settings
    Route::get('business/settings','BusinessController@index')->name('business.index');
    Route::post('seller/commission/update','BusinessController@commissionUpdate');
    Route::post('refferal/value/update','BusinessController@refferalValueUpdate');
    Route::post('first_order/value/update','BusinessController@firstOrderValueUpdate');
    //Profile
    Route::resource('profile','ProfileController');
    Route::put('password/update/{id}','ProfileController@updatePassword')->name('password.update');
    Route::get('get-all-vendors','VendorController@index')->name('get-all-vendors.index');
    Route::get('get-all-vendors/test','VendorController@indexTest')->name('get-all-vendors.index.test');
    Route::post('/get/all/shops/in/map', 'VendorController@nearestShp' )->name('get.shops.in.map');
    Route::get('seller-order-report','VendorController@sellerReport')->name('seller-order-report');
    //Route::post('seller-order-report','VendorController@sellerOrderDetails')->name('seller-order-report');
    Route::post('seller-order-details','VendorController@sellerOrderDetails')->name('seller-order-details');

    //Seller Payment
    Route::get('due-to-seller','PaymentController@dueToSeller')->name('due-to-seller');
    Route::post('due-to-seller-details','PaymentController@dueToSellerDetails')->name('due-to-seller-details');
    Route::get('due-to-admin','PaymentController@dueToAdmin')->name('due-to-admin');
    Route::post('due-to-admin-details','PaymentController@dueToAdminDetails')->name('due-to-admin-details');


    //performance
    Route::get('/config-cache', 'SystemOptimize@ConfigCache')->name('config.cache');
    Route::get('/clear-cache', 'SystemOptimize@CacheClear')->name('cache.clear');
    Route::get('/view-cache', 'SystemOptimize@ViewCache')->name('view.cache');
    Route::get('/view-clear', 'SystemOptimize@ViewClear')->name('view.clear');
    Route::get('/route-cache', 'SystemOptimize@RouteCache')->name('route.cache');
    Route::get('/route-clear', 'SystemOptimize@RouteClear')->name('route.clear');
    Route::get('/site-optimize', 'SystemOptimize@Settings')->name('site.optimize');

    Route::get('top-rated-shop','VendorController@topRatedShop')->name('top-rated-shop');
    Route::get('top-customers','CustomerController@topRatedCustomers')->name('top-customers');

});
