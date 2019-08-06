<?php

use Illuminate\Http\Request;

Route::get('customer/orders', 'Api\OrdersController@index');
Route::get('customer/orders/{orderId}', 'Api\OrdersController@show');
Route::get('cart', 'Api\CartController@index');
