<?php

Route::get('/', 'ProductController@index');
Route::get('/product/{product}', 'ProductController@show')->name('product.details');

Route::post('register', 'RegistrationController@register');
Route::get('register', 'RegistrationController@show');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('notice', 'RegistrationController@notifyEmail')->name('verification.notice');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::group([
    'prefix' => 'customer',
    'middleware' => ['auth', 'verified', 'customer']
], function () {
    Route::get('profile', 'CustomerProfileController@index')->name('customer.profile');
    Route::get('orders', 'OrdersController@index')->name('customer.order');
    Route::get('orders/{order}', 'OrdersController@show')->name('customer.orderDetails');
});

Route::name('cart.')->group(function () {
    Route::get('cart', 'CartController@index')->name('index');
    Route::post('cart', 'CartController@store');
    Route::delete('cart', 'CartController@destroy');
    Route::post('cart/update', 'CartController@update');
    Route::get('checkout', 'CartController@showCheckout')->name('checkout');
    Route::post('checkout', 'CartController@checkout');
});

// Vendor
Route::group([
    'prefix' => 'vendor'
], function () {
    Route::get('/', 'VendorController@index')->name('vendor.profile');
    Route::get('/products', 'VendorController@allProducts')->name('vendor.productList');
    Route::get('/products/add', 'VendorController@addProduct')->name('vendor.productAdd');
    Route::get('/products/{productId}', 'VendorController@productDetails')->name('vendor.productDetails');
    Route::get('orders/new', 'VendorController@newOrders')->name('vendor.newOrders');
});
