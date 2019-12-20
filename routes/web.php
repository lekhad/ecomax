<?php

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


Route::match(['get', 'post'], '/admin', 'AdminController@login');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Index Page
Route::get('/', 'IndexController@index');

//Category/Listing Page
Route::get('/products/{url}', 'ProductsController@products');

// Product Detail Page

Route::get('/product/{id}', 'ProductsController@product');


//Cart Page

Route::match(['get', 'post'], '/cart', 'ProductsController@cart');

// Add to Cart Route

Route::match(['get', 'post'], '/add-cart', 'ProductsController@addtocart');

// Deleting Product from cart Page

Route::get('/cart/delete-product/{id}', 'ProductsController@deleteCartProduct');

//Update Product quantity in Cart

Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductsController@updateCartQuantity');

// Get Product Attribute Price which is for the ajax request in main.js for detail page
Route::any('/get-product-price', 'ProductsController@getProductPrice');

//Apply Coupon

Route::post('/cart/apply-coupon', 'ProductsController@applyCoupon');

//Register/ Login
Route::get('/login-register', 'UsersController@userLoginRegister');

// Users Register Form Submit
Route::post('/user-register', 'UsersController@register');

//Confirm Account

Route::get('confirm/{code}', 'UsersController@confirmAccount');

Route::post('/user-login', 'UsersController@login');

Route::get('/user-logout', 'UsersController@logout');

//All Routes after Login
Route::group(['middleware'=> ['frontLogin']], function(){
    //User Account Page
    Route::match(['get', 'post'], 'account', 'UsersController@account');

    //Check User Current Password
    Route::post('/check-user-pwd', 'UsersController@chkUserPassword');

    // Update User Password
    Route::post('/update-user-pwd', 'UsersController@updatePassword');

    //Checkout Page
    Route::match(['get', 'post'], 'checkout', 'ProductsController@checkout');

    // Order Review Page
    Route::match(['get', 'post'], '/order-review', 'ProductsController@orderReview');

    // Place Order
    Route::match(['get', 'post'], '/place-order', 'ProductsController@placeOrder');

    //Thanks Page
    Route::get('/thanks', 'ProductsController@thanks');

    //Paypal Page
    Route::get('/paypal', 'ProductsController@paypal');

    //Users Orders Page
    Route::get('/orders', 'ProductsController@userOrders');

    //User ordered product pages
    Route::get('/orders/{id}', 'ProductsController@userOrderDetails');

    // Paypal Thanks Page
    Route::get('/paypal/thanks', 'ProductsController@thanksPaypal');

    // Paypal Cancel Page
    Route::get('/paypal/cance', 'ProductsController@cancelPaypal');
});
//Route::match(['get', 'post'], '/login-register', 'UsersController@register');


// Check if User already exist or not
//check-email is  Coming from the main.js of jquery

Route::match(['get', 'post'], '/check-email', 'UsersController@checkEmail');


Route::get('/logout', 'AdminController@logout');


// The admin/dashboard route works until being set in the RedirectIfAuthenticated

//Route::group(['middleware'=>['auth']], function(){
Route::group(['middleware'=>['adminLogin']], function(){
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/admin/settings', 'AdminController@settings');

    // The check-pwd works for matrix.form_validation.js
    Route::get('/admin/check-pwd', 'AdminController@chkPassword');
    Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@updatePassword');

    //Categories Route (Admin)
    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory');
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory');

    Route::match(['get', 'post'], '/admin/delete-category/{id}', 'CategoryController@deleteCategory');
    Route::get('/admin/view-categories', 'CategoryController@viewCategories');

    // Products Routes
    Route::match(['get', 'post'], '/admin/add-product', 'ProductsController@addProduct');
    Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductsController@editProduct');
    Route::get('/admin/view-products', 'ProductsController@viewProducts');
    Route::get('/admin/delete-product/{id}', 'ProductsController@deleteProduct');
    Route::get('/admin/delete-product-image/{id}', 'ProductsController@deleteProductImage');
    Route::get('/admin/delete-alt-image/{id}', 'ProductsController@deleteAltImage');

    // Products Attributes Routes
    Route::match(['get', 'post'], 'admin/add-attributes/{id}', 'ProductsController@addAttributes');
    Route::match(['get', 'post'], 'admin/edit-attributes/{id}', 'ProductsController@editAttributes');
    Route::match(['get', 'post'], 'admin/add-images/{id}', 'ProductsController@addImages');
    Route::get('/admin/delete-attribute/{id}', 'ProductsController@deleteAttribute');

    //Coupon Routes
    Route::match(['get', 'post'], '/admin/add-coupon', 'CouponsController@addCoupon');
    Route::match(['get', 'post'], 'admin/edit-coupon/{id}', 'CouponsController@editCoupon');
    Route::get('/admin/view-coupons', 'CouponsController@viewCoupons');
    Route::get('/admin/delete-coupon/{id}', 'CouponsController@deleteCoupon');

    //Admin Banners Routes
    Route::match(['get', 'post'], '/admin/add-banner', 'BannersController@addBanner');
    Route::match(['get', 'post'], '/admin/edit-banner/{id}', 'BannersController@editBanner');
    Route::get('/admin/view-banners', 'BannersController@viewBanners');
    Route::get('/admin/delete-banner/{id}', 'BannersController@deleteBanner');

    //Admin Orders Routes
    Route::get('/admin/view-orders', 'ProductsController@viewOrders');

    // Admin Order Details Route
    Route::get('/admin/view-order/{id}', 'ProductsController@viewOrderDetails');

    // Update Order Status
    Route::post('/admin/update-order-status', 'ProductsController@updateOrderStatus');

    //Admin Users Route
    Route::get('/admin/view-users', 'UsersController@viewUsers');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
