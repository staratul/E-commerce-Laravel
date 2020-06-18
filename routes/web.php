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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/contact', 'Frontend\PageController@contact');
Route::get('/blog-details', 'Frontend\PageController@blogDetails');
Route::get('/blog', 'Frontend\PageController@blog');
Route::get('/checkout', 'Frontend\PageController@checkOut');
Route::get('/faq', 'Frontend\PageController@faq');
Route::get('/product', 'Frontend\PageController@product');
Route::get('/shop', 'Frontend\PageController@shop');
Route::get('/shopping-cart', 'Frontend\PageController@shoppingCart');
// Product Control
Route::get('womens-clothing', 'Frontend\ProductCategoryController@womensClothing');
Route::get('mens-clothing', 'Frontend\ProductCategoryController@mensClothing');
Route::get('kids-clothing', 'Frontend\ProductCategoryController@kidsClothing');
Route::get('home-living', 'Frontend\ProductCategoryController@homeLiving');
Route::get('accessories', 'Frontend\ProductCategoryController@accessories');
Route::get('essentials', 'Frontend\ProductCategoryController@essentials');
Route::get('luxury-brands', 'Frontend\ProductCategoryController@luxuryBrands');


Route::prefix('admin')->group(function() {
	Route::get('/', 'AdminController@admin');
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
});

Route::middleware(['auth:admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::any('categories', 'Admin\HeaderController@category')->name('admin.categories');
    Route::any('/menus', 'Admin\HeaderController@menu')->name('admin.menus');
    Route::any('/tags', 'Admin\HeaderController@tag')->name('admin.tags');
    Route::any('/home-slider', 'Admin\HomePageController@homeSlider')->name('admin.home.slider');
    Route::any('/add-home-slider', 'Admin\HomePageController@addHomeSlider')->name('add.home.slider');
});

