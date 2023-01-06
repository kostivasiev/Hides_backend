<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
}); */

Route::apiResource('users', 'API\ApiController');

Route::get('/createuser', [
    'uses' => 'API\ApiController@createuser',
]);

Route::get('/members', [
    'uses' => 'API\ApiController@show',
]);


Route::post('/register-user', [
    'uses' => 'API\ApiController@createmembershipuser',
]);
Route::post('/login-users', [
    'uses' => 'API\ApiController@loginmembers',
]);
Route::post('/update-users', [
    'uses' => 'API\ApiController@updatedmemberprofile',
]);
Route::post('/uploadimage', [
    'uses' => 'API\ApiController@uploadimage',
]);
Route::post('/uploadimage1', [
    'uses' => 'API\ApiController@uploadimage1',
]);
Route::get('/downloadFile', [
    'uses' => 'API\ApiController@downloadFile',
]);
Route::get('/cloud-status', [
    'uses' => 'API\ApiController@cloudStatus',
]);

Route::post('/delete-images', [
    'uses' => 'API\ApiController@deleteFile',
]);


Route::post('/send-otp', [
    'uses' => 'API\ApiController@sendVerificationCode',
]);

Route::post('/check-otp', [
    'uses' => 'API\ApiController@checkOTPcode',
]);