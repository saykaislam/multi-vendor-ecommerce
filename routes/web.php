<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/', 'Frontend\FrontendController@index')->name('index');
Route::get('/shopping-cart', 'Frontend\CartController@viewCart')->name('shopping-cart');
Route::get('/about-us', 'Frontend\AboutController@About')->name('about-us');
Route::get('/contact', 'Frontend\AboutController@contact')->name('contact');
Route::get('/faqs', 'Frontend\AboutController@faqs')->name('faqs');
Route::get('/our-policy', 'Frontend\AboutController@policy')->name('policy');
Route::get('/terms-and-conditions', 'Frontend\AboutController@terms')->name('terms-condition');
Route::get('/shipping', 'Frontend\AboutController@shipping')->name('shipping');
Route::get('/order-returns', 'Frontend\AboutController@returns')->name('returns');
Route::get('/blog-list', 'Frontend\BlogController@index')->name('blog-list');
Route::get('/blog-details/{slug}', 'Frontend\BlogController@details')->name('blog-details');
Route::get('/add/wishlist/{id}', 'Frontend\WishlistController@wishlistAdd' )->name('add.wishlist');
Route::get('/remove/wishlist/{id}', 'Frontend\WishlistController@wishlistRemove' )->name('remove.wishlist');
Route::get('/add/favorite-shop/{id}', 'User\FavoriteShopController@favoriteShop')->name('add.favorite-shop');
Route::get('/remove/favorite-shop/{id}', 'User\FavoriteShopController@removeFavoriteShop')->name('remove.favorite-shop');
Route::get('/shops','Frontend\ShopController@index')->name('all.shops');

//Search
Route::get('/search/product', 'Frontend\VendorController@search_product');
Route::get('/search/category/product', 'Frontend\VendorController@search_category_product');
Route::get('/search/subcategory/product', 'Frontend\VendorController@search_subcategory_product');
Route::get('/product/filter/{data}/shopId/{shopId}', 'Frontend\VendorController@productFilter');
Route::get('/featured-product/subcategories/filter/{data}/sellerId/{id}/sub/{subId}', 'Frontend\VendorController@FeaturedSubFilter');
Route::get('/todays-deal/product/filter/{data}/shopId/{shopId}', 'Frontend\VendorController@todaysDealFilter');
Route::get('/todays-deal/subcategories/filter/{data}/sellerId/{id}/sub/{subId}', 'Frontend\VendorController@todaysDealSubFilter');
Route::get('/best-selling/product/filter/{data}/shopId/{shopId}', 'Frontend\VendorController@bestSellingFilter');
Route::get('/best-selling/subcategories/filter/{data}/sellerId/{id}/sub/{subId}', 'Frontend\VendorController@bestSellingSubFilter');
Route::get('/brand/product/filter/{data}/shopId/{id}/brand/{brndId}', 'Frontend\VendorController@brandFilter');



Route::post('/registration','Frontend\FrontendController@register')->name('user.register');
Route::get('/get-verification-code/{id}', 'Frontend\VerificationController@getVerificationCode')->name('get-verification-code');
Route::post('/get-verification-code-store', 'Frontend\VerificationController@verification')->name('get-verification-code.store');
Route::get('/check-verification-code', 'Frontend\VerificationController@CheckVerificationCode')->name('check-verification-code');
Route::get('refer/{code}','Frontend\FrontendController@referCode')->name('registration.refer.code');
Route::get('popup-dataset','Frontend\FrontendController@popupDataSet')->name('popup-dataset');
Route::get('popup-destroy','Frontend\FrontendController@popupDataDestroy')->name('popup-destroy');





//product
Route::get('/product/{slug}', 'Frontend\ProductController@ProductDetails')->name('product-details');
Route::post('/products/get/variant/price', 'Frontend\ProductController@ProductVariantPrice')->name('product.variant.price');
Route::get('/featured-products/{slug}', 'Frontend\ProductController@featuredProductList')->name('featured-product.list');
Route::get('/products/{name}/{slug}/{sub}', 'Frontend\ProductController@productSubCategory')->name('product.by.subcategory');
Route::get('/products/{name}/{slug}', 'Frontend\ProductController@productByBrand')->name('product.by.brand');
Route::post('/products/ajax/addtocart', 'Frontend\CartController@ProductAddCart')->name('product.add.cart');
Route::get('/product/clear/cart', 'Frontend\CartController@clearCart')->name('product.clear.cart');
Route::get('/product/remove/cart/{id}', 'Frontend\CartController@cartRemove')->name('product.cart.remove');
Route::post('/cart/quantity_update', 'Frontend\CartController@quantityUpdate')->name('qty.update');
Route::get('/best-sells/products','Frontend\ProductController@bestSellsProducts')->name('best-sells-all-products');
//Shop/Vendor
Route::post('/shop/nearest/list', 'Frontend\ShopController@nearestshop')->name('shop.nearest');


Route::get('/become-a-vendor', 'Frontend\VendorController@index')->name('become-vendor');
Route::get('/shop/{name}/{slug}', 'Frontend\VendorController@categoryProducts')->name('category.products');
Route::get('/shop/{slug}/{cat}/{sub}', 'Frontend\VendorController@subCategoryProducts')->name('subcategory.products');
Route::get('/shop/{shop}/{cat}/{sub}/{subsub}', 'Frontend\VendorController@subSubCategoryProducts');
Route::get('/shop/{slug}', 'Frontend\VendorController@singleshop')->name('shop.details');
Route::get('/categories/{slug}', 'Frontend\VendorController@allCategories')->name('view.all.categories');
Route::get('/best-seller-shop/list', 'Frontend\ShopController@bestSellerShopList')->name('best-seller.shop-list');
Route::get('/flash-deals/{slug}', 'Frontend\VendorController@flashdeal')->name('flash-deals');
Route::get('/todays-deal/{slug}', 'Frontend\VendorController@todaysDeal')->name('todays-deal-products');
Route::get('/todays-deal/{name}/{slug}/{sub}', 'Frontend\VendorController@todaysDealSubCategory');
Route::get('/best-selling/{slug}', 'Frontend\VendorController@bestSelling')->name('best-selling-products');
Route::get('/best-selling/{name}/{slug}/{sub}', 'Frontend\VendorController@bestSellingSubCategory');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/reset-password','Frontend\FrontendController@getPhoneNumber')->name('reset.password');
Route::post('/otp-store','Frontend\FrontendController@checkPhoneNumber')->name('phone.check');
Route::post('/change-password','Frontend\FrontendController@otpStore')->name('otp.store');
Route::post('/new-password/update/{id}','Frontend\FrontendController@passwordUpdate')->name('reset.password.update');
//Route::post('/reset-password', '\App\Http\Controllers\Auth\LoginController@reset_pass_check_mobile')->name('reset.pass.mobile');
//Route::post('/reset-password/send', '\App\Http\Controllers\Auth\LoginController@reset_pass')->name('reset.pass');


Route::group(['middleware' => ['auth', 'user']], function () {
    //this route only for with out resource controller
    Route::get('/user/dashboard', 'User\DashboardController@index')->name('user.dashboard');
    Route::get('/user/edit-profile', 'User\DashboardController@editProfile')->name('user.edit-profile');
    Route::post('/user/profile/update', 'User\DashboardController@updateProfile')->name('user.profile-update');
    Route::get('/user/edit-password', 'User\DashboardController@editPassword')->name('user.edit-password');
    Route::post('/user/password/update', 'User\DashboardController@updatePassword')->name('user.password-update');
    Route::get('/user/invoices', 'User\DashboardController@invoices')->name('user.invoices');
    Route::get('/user/notifications', 'User\DashboardController@notification')->name('user.notification');
//    Route::get('/user/address', 'User\DashboardController@address')->name('user.address');
//    Route::post('/user/address/update', 'User\DashboardController@updateAddress')->name('user.address-update');
    Route::get('/user/order/history', 'User\OrderManagementController@orderHistory')->name('user.order.history');
    Route::get('/user/order/details/{id}', 'User\OrderManagementController@orderDetails')->name('user.order.details');
    Route::post('/user/order/review', 'User\OrderManagementController@reviewStore')->name('user.order.review.store');
    Route::get('order-details/invoice/print/{id}','User\OrderManagementController@printInvoice')->name('invoice.print');
    Route::get('/user/wishlist', 'Frontend\WishlistController@wishlist')->name('user.wishlist');
    Route::get('/user/favorite-shops', 'User\DashboardController@favoriteShop')->name('user.favorite.shop');
    Route::get('/checkout', 'Frontend\CartController@checkout')->name('checkout');
    Route::post('/checkout/order/submit', 'Frontend\CartController@orderSubmit')->name('checkout.order.submit');
    //this route only for resource controller
    Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User',], function () {
        Route::resource('address', 'AddressController');
    });
    Route::post('/user/address-status/update/{id}', 'User\AddressController@updateStatus')->name('user.update.status');
});
//Route::get('/vendor/dashboard', 'Vendor\DashboardController@index')->name('vendor.dashboard');


