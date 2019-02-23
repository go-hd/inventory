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

Route::resource('/brands', 'BrandController');
Route::resource('/companies', 'CompanyController');
Route::resource('/locations', 'LocationController');
Route::resource('/location_types', 'LocationTypeController');
Route::resource('/lots', 'LotController');
Route::resource('/pallets', 'PaletteController');
Route::resource('/recipes', 'RecipeController');
Route::resource('/stock_histories', 'StockHistoryController');
Route::resource('/stock_history_types', 'StockHistoryTypeController');
Route::resource('/stock_moves', 'StockMoveController');
Route::resource('/users', 'UserController');

