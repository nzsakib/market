<?php

Route::get('/', 'ProductController@index');
Route::get('/product/{product}', 'ProductController@show')->name('product.details');

Route::post('register', 'RegistrationController@register');
Route::get('notify', 'RegistrationController@emailNotify')->name('register.notify');
Route::get('register', 'RegistrationController@show');
