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

Route::get('/', 'PilpresController@index')->name('home');
Route::get('/coba', 'PilpresController@coba')->name('coba');
Route::get('/data/suara', 'PilpresController@api')->name('data.suara');
Route::get('/data/proses', 'PilpresController@proggress')->name('data.proses');


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
