<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user/dashboard','Api\CustomerController@index');
    Route::get('/user/profile/info','Api\CustomerController@profileInfo');
    Route::post('/user/profile/update', 'Api\CustomerController@profileUpdate');
    Route::post('/user/password/update', 'Api\CustomerController@passwordUpdate');
    Route::get('/user/address', 'Api\AddressController@index');
    Route::post('/user/address/add', 'Api\AddressController@store');
    Route::post('/user/address/set-default/{id}', 'Api\AddressController@setDefault');
    Route::delete('/user/address/delete/{id}', 'Api\AddressController@destroy');
    Route::post('/user/address/update', 'Api\CustomerController@addressUpdate');
    Route::get('/user/wishlist', 'Api\CustomerController@wishlist');
    Route::post('/add/wishlist/{id}', 'Api\CustomerController@wishlistAdd' );
    Route::delete('/remove/wishlist/{id}', 'Api\CustomerController@wishlistRemove' );
    Route::get('/user/orders', 'Api\OrderController@order_get');
    Route::get('/user/order/details/{id}', 'Api\OrderController@order_details_get');
    Route::post('/user/order/submit', 'Api\OrderController@orderSubmit');
    Route::post('/user/order/review/submit', 'Api\OrderController@reviewStore');
    Route::get('/user/order/all-reviews', 'Api\OrderController@getReview');

    //User Favorite Shop
    Route::post('/add/favorite-shop', 'Api\CustomerController@favoriteShopAdd' );
    Route::post('/remove/favorite-shop', 'Api\CustomerController@favoriteShopRemove' );

    //Seller
    Route::get('/seller/dashboard', 'Api\SellerController@dashboard');
    Route::get('/seller/info', 'Api\SellerController@profile');
    Route::post('/seller/profile-update', 'Api\SellerController@profileUpdate');
    Route::post('/seller/password-update', 'Api\SellerController@passwordUpdate');
    Route::post('/seller/bank-details-update', 'Api\SellerController@bankDetailsUpdate');
    Route::post('/seller/nid-info-update', 'Api\SellerController@nidInfoUpdate');
    Route::get('/seller/shop/info', 'Api\SellerController@shopInfo');
    Route::post('/seller/shop/info-update', 'Api\SellerController@shopInfoUpdate');
    Route::get('/seller/verification-status', 'Api\SellerController@verificationStatus');

    //Seller Products
    Route::get('/seller/all-products', 'Api\SellerController@allProducts');
    Route::post('/seller/products/todays_deal-update', 'Api\SellerController@updateTodaysDeal');
    Route::post('/seller/products/published-update', 'Api\SellerController@updatePublished');
    Route::post('/seller/products/featured-update', 'Api\SellerController@updateFeatured');

    //Seller Order Details
    Route::get('/seller/orders', 'Api\SellerController@getOrders');
    Route::get('/seller/order/details/{id}', 'Api\SellerController@getOrderDetails');

    //Seller Products Flash Deal Products
//    Route::get('/seller/all-flash-deal-products', 'Api\SellerController@allFlashDealProducts');

    //Seller Order Management
    Route::get('/seller/all-orders', 'Api\SellerController@allOrders');
    Route::post('/seller/delivery-status/update', 'Api\SellerController@deliveryStatusUpdate');

    //Seller Payment Details
    Route::get('/seller/pending-balance', 'Api\SellerPaymentController@pendingBalance');
    Route::post('/seller/withdraw-request', 'Api\SellerPaymentController@withdrawRequest');
    Route::get('/seller/withdraw-request/history', 'Api\SellerPaymentController@withdrawRequestHistory');
    Route::get('/seller/payment-history', 'Api\SellerPaymentController@paymentHistory');
    Route::get('/seller/payment-report', 'Api\SellerPaymentController@paymentReport');


});


Route::get('/brands','Api\BrandController@getBrands');
Route::get('/categories','Api\CategoryController@getCategories');
Route::get('/subcategories','Api\SubcategoryController@getSubcategories');
Route::get('/shops','Api\ShopController@getShop');
Route::get('/shops/lat/{lat}/lng/{lng}','Api\ShopController@getShopByLatLng');
Route::get('/sellers','Api\SellerController@getSellers');
Route::get('/shop-categories','Api\ShopCategoryController@getShopCategories');
Route::get('/shop-brands','Api\ShopBrandController@getShopBrands');
Route::get('/sliders','Api\SliderController@getSliders');
Route::get('/featured-products/{id}','Api\ProductController@getFeaturedProducts');
Route::get('/product/details/{id}','Api\ProductController@productDetails');
Route::post('product/variant/price', 'Api\ProductController@variantPrice');
Route::get('/shop-categories/{id}','Api\ShopCategoryController@getShopCategory');
Route::get('/todays-deal-products/{id}','Api\ProductController@getTodaysDeal');
Route::get('/best-sales-products/{id}','Api\ProductController@getBestSales');
Route::get('/flash-deals-products/{id}','Api\ProductController@getFlashDeals');
Route::get('/related-products/{id}','Api\ProductController@getRelatedProducts');
Route::post('/search/product', 'Api\ProductController@search_product');

Route::post('/category/featured-products', 'Api\CategoryController@featuredProducts');
Route::post('/category/all-products', 'Api\CategoryController@categoryAllProducts');
//Route::get('/shop-subcategory', 'Api\CategoryController@categoryProducts');

//Shop Subcategory
Route::post('/shop-subcategories','Api\ShopSubcategoryController@getShopSubcategories');
Route::post('/shop-subcategories/featured-products','Api\ShopSubcategoryController@getFeaturedProducts');
Route::post('/shop-subcategories/all-products','Api\ShopSubcategoryController@getAllProducts');

// Shop Ratings
Route::get('/shop-total-ratings/{id}','Api\ShopController@getShopRatings');

//Shop Subcategory
Route::post('/shop-subsubcategories','Api\ShopSubSubCategoryController@getShopSubSubcategories');
Route::post('/shop-subsubcategories/featured-products','Api\ShopSubSubCategoryController@getFeaturedProducts');
Route::post('/shop-subsubcategories/all-products','Api\ShopSubSubCategoryController@getAllProducts');


Route::get('/favorite-shops', 'Api\CustomerController@getFavoriteShop' );
Route::get('/product/reviews/{id}','Api\ProductController@allReviews');

//Offers
Route::get('/offers','Api\OfferController@getOffers');

Route::post('/login','Api\AuthController@login');
Route::post('/register','Api\AuthController@register');
Route::post('/seller/register','Api\AuthController@sellerRegister');
Route::post('/verification-code-store', 'Api\AuthController@verificationStore');
Route::post('/resend-otp', 'Api\AuthController@resendOtp');
Route::get('/check-verification-code', 'Api\AuthController@CheckVerificationCode');
Route::post('/phone/check','Api\AuthController@checkPhoneNumber');
Route::post('/new-password/update','Api\AuthController@passwordUpdate');

//Customer Api
//Route::post('/user/profile/update', 'Api\CustomerController@profileUpdate')->middleware('auth:api');


