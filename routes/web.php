<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/users', 'UserController');
Route::resource('/locations', 'LocationController');
Route::resource('/products', 'ProductController');
Route::resource('/product-stocks', 'ProductStockController');
Route::resource('/palettes', 'PaletteController');
Route::resource('/delivery-histories', 'DeliveryHistoryController');
Route::resource('/order-histories', 'OrderHistoryController');

