<?php

Route::get('customer/orders', 'Api\OrdersController@index');
Route::get('customer/orders/{orderId}', 'Api\OrdersController@show');
Route::get('cart', 'Api\CartController@index');

Route::post('customer/profile', 'Api\CustomerProfileController@update');
Route::post('customer/profile/photo', 'Api\CustomerProfileController@updatePhoto');
Route::post('customer/profile/password', 'Api\CustomerProfileController@updatePassword');
Route::get('customer/profile', 'Api\CustomerProfileController@index');

// vendor
// middleware only for vendor
Route::apiResource('vendor/product', 'Api\VendorProductController', [
    'as' => 'vendor',
    'middleware' => 'auth'
]);
// get vendor products
