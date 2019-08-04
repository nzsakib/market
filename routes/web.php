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
    Route::get('dashboard', 'VerificationController@success')->name('customer.dashboard');
});
