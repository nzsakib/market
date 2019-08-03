<?php

Route::get('/', 'ProductController@index');
Route::get('/product/{product}', 'ProductController@show')->name('product.details');