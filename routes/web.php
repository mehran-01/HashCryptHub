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

// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::resource('offers', 'OfferController');

Route::get('/','SearchController@index');

Route::get('/search','SearchController@search');

Route::get('offers/{offer}/status/{status}','OfferController@status');

Route::post('offer/{offer_id}/buy/{trade_offer}','OfferController@buy');

Route::get('/trades','TradeController@index');

Route::post('/trade/{trade_id}/sell','TradeController@sell');

Route::get('/trade/{trade_id}/cancel','TradeController@cancel');

