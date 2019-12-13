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

Route::resource('/brands', 'BrandController', ['except' => ['show']]);
Route::get('/brands/get_has_lots', 'BrandController@getHasLots');
Route::resource('/companies', 'CompanyController');
Route::post('/companies/validate', 'CompanyController@validation');
Route::resource('/locations', 'LocationController');
Route::post('/locations/validate', 'LocationController@validation');
Route::resource('/location_types', 'LocationTypeController');
Route::resource('/lots', 'LotController');
Route::resource('/palettes', 'PaletteController');
Route::post('/location_palettes/move', 'LocationPaletteController@move');
Route::resource('/materials', 'MaterialController', ['except' => ['show']]);
Route::post('/materials/update_multi', 'MaterialController@updateMulti');
Route::resource('/stock_histories', 'StockHistoryController', ['except' => ['show']]);
Route::get('/stock_histories/get_quantity/{location_id}/{lot_id}', 'StockHistoryController@getQuantity');
Route::resource('/stock_history_types', 'StockHistoryTypeController');
Route::resource('/stock_moves', 'StockMoveController', ['except' => ['show']]);
Route::post('/stock_moves/shipped/{id}', 'StockMoveController@shipped');
Route::post('/stock_moves/recieved/{id}', 'StockMoveController@recieved');
Route::resource('/users', 'UserController');
Route::post('/users/validate', 'UserController@validation');
Route::post('/users/register', 'UserController@register');
Route::post('/users/invite', 'UserController@invite');
Route::resource('/products', 'ProductController');

Route::resource('/user_verifications', 'UserVerificationController')->only('store');
Route::get('/user_verifications/verify', 'UserVerificationController@verify');

Route::post('/register', 'RegisterController@register');
Route::post('/register/invited', 'RegisterController@registerInvited');

