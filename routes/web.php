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
Route::get('/get','PaczkaKrajowaController@get_parrams');
Route::get('/save','PaczkaKrajowaController@save_all');
Route::get('/testy' , "PaczkaKrajowaController@emsTesty");
Route::get('/xls' , "PaczkaKrajowaController@saveMainRaportAndGetOtherXls");