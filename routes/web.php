<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('/sales', 'SalesController');
    Route::resource('/engines', 'EngineController');
    Route::resource('/orders', 'OrderController');
});
