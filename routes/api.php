<?php

use Illuminate\Http\Request;
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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ShowUser','Admin\AdminController@viewUser');


Route::delete('/DeleteUser/{id}','Admin\AdminController@destroy');

Route::delete('/AddSerwisant/{id}','Admin\AdminController@addSerwisant');

Route::delete('/AddAdmin/{id}','Admin\AdminController@addAdmin');

Route::delete('/DeleteAdmin/{id}','Admin\AdminController@deleteAdmin');

Route::delete('/DeleteSerwisant/{id}','Admin\AdminController@deleteSerwisant');

Route::delete('/AddBan/{id}','Admin\AdminController@addBan');

Route::delete('/DeleteBan/{id}','Admin\AdminController@deleteBan');