<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/forgot-session', 'Frontend\PageController@sessionForgot');

Route::get('/', 'Frontend\PageController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/contact', 'Frontend\PageController@contact');
Route::get('/blog-details', 'Frontend\PageController@blogDetails');
Route::get('/blog', 'Frontend\PageController@blog');
Route::get('/faq', 'Frontend\PageController@faq');

// Product
Route::get('/product-details/{product}/{slug}', 'Frontend\PageController@productDetails')
            ->name('product.details');
Route::get('/product-list/{category}/{category_id}/{subCategory}/{subCategory_id}',              'Frontend\PageController@productList')->name('product.list');

Route::get('/shop', 'Frontend\PageController@shop');
Route::get('/shopping-cart', 'Frontend\PageController@shoppingCart');

// Product Control
Route::get('/womens-clothing', 'Frontend\ProductCategoryController@womensClothing');
Route::get('/mens-clothing', 'Frontend\ProductCategoryController@mensClothing');
Route::get('/kids-clothing', 'Frontend\ProductCategoryController@kidsClothing');
Route::get('/home-living', 'Frontend\ProductCategoryController@homeLiving');
Route::get('/accessories', 'Frontend\ProductCategoryController@accessories');
Route::get('/essentials', 'Frontend\ProductCategoryController@essentials');
Route::get('/luxury-brands', 'Frontend\ProductCategoryController@luxuryBrands');

// Shopping Cart
Route::any('add-cart', 'Frontend\Shoppings\ShoppingController@addToCart')
        ->name('addcart');
Route::any('add-cart-notifications/{cart}', 'Frontend\Shoppings\ShoppingController@cartNotifications')
        ->name('cart.notifications');
Route::post('/remove-cart-item', 'Frontend\Shoppings\ShoppingController@removeCartItem')
        ->name('remove.cartitem');
Route::post('/decrease-cart-qty', 'Frontend\Shoppings\ShoppingController@decreaseCartQty')
        ->name('decrease.cartquantity');
Route::post('/increase-cart-qty', 'Frontend\Shoppings\ShoppingController@increaseCartQty')
        ->name('increase.cartquantity');

Route::middleware(['isvalid-for-shopping'])->group(function() {
    Route::any(
        'otp-verification/{userDetail}/{oTPVerification}', 'Email\EmailVerificationController@otpVerification')->name('otpVerification');
});

Route::middleware(['isvalid-for-payment'])->group(function() {
    Route::get(
        'checkout-payment/{userDetail}', 'Frontend\Shoppings\CheckoutController@getCheckoutPayment')
        ->name('checkout.payemnt');
    Route::post(
        'checkout-payment/{userDetail}', 'Frontend\Shoppings\CheckoutController@postCheckoutPayment')
        ->name('checkout.payemnt');
    Route::post(
            'pay-on-delivery/{userDetail}', 'Frontend\Shoppings\CheckoutController@payOnDelivery')
        ->name('pay.on.delivery');
    Route::any('check-out/payment/{userDetail}/{type}',
            'Frontend\Shoppings\CheckoutController@upiPaymentChoose')->name('choose.upi.payment');

    // Paytm Payment Route
    Route::get('/initiate/payment/{userDetail}/{typeId}','Frontend\Shoppings\PaytmController@initiate')
        ->name('initiate.payment');
    Route::post('/paytm/payment/{userDetail}/{typeId}','Frontend\Shoppings\PaytmController@pay')
        ->name('make.payment');
    Route::post('/payment/status/{userDetail}/{typeId}', 'Frontend\Shoppings\PaytmController@paymentCallback')->name('status.payment');

    // PayPal Payment Route
    Route::get('paypal/{userDetail}/{typeId}', 'Frontend\Shoppings\PayPalController@paypal')
        ->name('payment.paypal');
    Route::get('paypal-payment/{userDetail}/{typeId}', 'Frontend\Shoppings\PayPalController@payment')
        ->name('paypal.payment');
    Route::get('paypal/payment-cancel', 'Frontend\Shoppings\PayPalController@cancel')
        ->name('payment.cancel');
    Route::get('paypal/payment-success/{userDetail}/{typeId}', 'Frontend\Shoppings\PayPalController@success')->name('payment.success');
});

// Order Details Route
Route::get('order-details/{userDetail}', 'Frontend\Shoppings\ShoppingController@orderDetails')
    ->name('order.details');

// Checkout
Route::get('/checkout', 'Frontend\Shoppings\ShoppingController@cartCheckOut')
        ->name('cart.checkout');
Route::post(
        'checkout-placeorder', 'Frontend\Shoppings\ShoppingController@placeOrder')
        ->name('checkout.placeorder');
Route::get('send-otp/{userDetail}', 'Email\EmailVerificationController@sendOTP')
        ->name('send.OTP');


Route::prefix('/')->group(function() {
	Route::get('/admin', 'AdminController@admin');
	Route::get('admin-login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('admin-login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
});

Route::middleware(['auth:admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    // Categories Routes
    Route::any('categories', 'Admin\HeaderController@category')->name('admin.categories');
    // Menues Routes
    Route::any('/menus', 'Admin\HeaderController@menu')->name('admin.menus');
    // Tags Route
    Route::any('/tags', 'Admin\HeaderController@tag')->name('admin.tags');
    // Payment Types
    Route::any('/payment-type', 'Admin\HomePageController@paymentTypes')->name('payment.type');
    // Home Slider routes
    Route::any('/home-slider', 'Admin\HomePageController@homeSlider')->name('admin.home.slider');
    Route::any('/add-home-slider', 'Admin\HomePageController@addHomeSlider')->name('add.home.slider');
    Route::get('/edit-home-slider\{homeSlider}', 'Admin\HomePageController@editHomeSlider')
        ->name('edit-home-slider');
    Route::get('/delete-home-slider\{homeSlider}', 'Admin\HomePageController@deleteHomeSlider')
        ->name('delete-home-slider');

    // Product Routes
    Route::resource('products', 'Admin\Products\ProductController');
    Route::any('products-size', 'Admin\Products\ProductTypeController@productSize')
        ->name('products.size');
    Route::any('products-color', 'Admin\Products\ProductTypeController@productColor')
        ->name('products.color');
    Route::any('state', 'Admin\Products\ProductTypeController@state')->name('products.state');
    Route::any('brand', 'Admin\Products\ProductTypeController@brand')->name('products.brand');
});

