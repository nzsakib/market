<?php

Route::get('/', 'ProductController@index');
Route::get('/product/{product}', 'ProductController@show')->name('product.details');

Route::post('register', 'RegistrationController@register');
Route::get('notify', 'RegistrationController@emailNotify')->name('register.notify');
Route::get('register', 'RegistrationController@show');
Route::get('verify', 'VerificationController@verify');
Route::get('success', 'VerificationController@success')->name('verify.success');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

Route::group([
    'prefix' => 'customer'
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
