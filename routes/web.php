<?php

Route::get('/', 'ProductController@index');
Route::get('/product/{product}', 'ProductController@show')->name('product.details');

Route::post('register', 'RegistrationController@register');
Route::get('notify', 'RegistrationController@emailNotify')->name('register.notify');
Route::get('register', 'RegistrationController@show');
Route::get('verify', 'VerificationController@verify');
Route::get('success', 'VerificationController@success')->name('verify.success');
Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');

Route::group([
    'prefix' => 'customer'
], function () {
    Route::get('profile', 'CustomerProfileController@index')->name('customer.profile');
});

Route::get('cart', 'CartController@index');
Route::post('cart', 'CartController@store');
Route::delete('cart', 'CartController@destroy');
