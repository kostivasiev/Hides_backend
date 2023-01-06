<?php

use Illuminate\Support\Facades\Route;

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




Route::get('/', 'Site\LoginController@showlogin') ;
Route::post('checklogin', 'Site\LoginController@checklogin');
Route::get('dashboard', 'Site\LoginController@successlogin');
Route::get('logout', 'Site\LoginController@logout');
Route::get('search', 'Site\SearchController@search');
Route::get('deleteUsermember/{id}', 'Site\LoginController@deleteusermembership');
Route::get('uploadform', 'Site\StoreController@index');
Route::get('uploadimages', 'Site\StoreController@show');
Route::post('upload', 'Site\StoreController@store')->name('uploadFile');
Route::get('/files/{filename}', 'Site\StoreController@downloadFile')->name('downloadFile');
//Route::post('/files', 'Site\StoreController@downloadFile')->name('downloadFile');