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
//     return view('layouts.cekongkir');
// });


Route::get('/', 'RajaOngkirController@index');
Route::get('pilih_kab','RajaOngkirController@pilih_kab');
Route::get('harga','RajaOngkirController@harga');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
