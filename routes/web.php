<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/dashboard', 'DashboardController@index');
    Route::resource('/sales', 'SalesController');
    Route::resource('/engines', 'EngineController');
    Route::resource('/orders', 'OrderController');
    Route::put('/orders/start/{id}', 'OrderController@startOrder');
    Route::get('/orders/detail/{id}', 'OrderDetailController@index');
});
