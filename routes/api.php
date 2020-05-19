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

Route::post('/admin/addCategory','Admin\AdminController@addCategory');

Route::get('/admin/showCategory','Admin\AdminController@showCategory');

Route::delete('/admin/deleteCategory/{id}','Admin\AdminController@deleteCategory');

Route::put('/admin/updateCategory/{id}','Admin\AdminController@updateCategory');

Route::get('/admin/showBrands/{id}','Admin\AdminController@showBrands');

Route::delete('/admin/deleteBrand/{id}','Admin\AdminController@deleteBrand');

Route::put('/admin/updateBrand/{id}','Admin\AdminController@updateBrand');

Route::post('/admin/addBrand/{id}','Admin\AdminController@addBrand');

Route::get('/admin/categoryName/{id}','Admin\AdminController@categoryName');

Route::get('/admin/showDevices/{id}','Admin\AdminController@showDevices');

Route::delete('/admin/deleteDevice/{id}','Admin\AdminController@deleteDevice');

Route::put('/admin/updateDevice/{id}','Admin\AdminController@updateDevice');

Route::post('/admin/addDevice/{id}','Admin\AdminController@addDevice');

Route::get('/admin/showDeviceRepairs/{id}','Admin\AdminController@showDeviceRepairs');

Route::put('/admin/akceptujnaprawe/{id}','Admin\AdminController@akceptujnaprawe');

Route::put('/admin/odrzucnaprawe/{id}','Admin\AdminController@odrzucnaprawe');

Route::put('/admin/przekazdorealziacji/{id}','Admin\AdminController@przekazdorealziacji');

Route::delete('/deleteRepair/{id}','Admin\AdminController@deleteRepair');

Route::post('/serwisant/addRepair/{id}','Serwisant\SerwisantController@addRepair');

Route::get('/serwisant/showRepairs/{id}','Serwisant\SerwisantController@showRepairs');

Route::post('/serwisant/naprawa/step/{id}','Serwisant\SerwisantController@addStepRepair');

Route::get('/serwisant/showSteps/{id}','Serwisant\SerwisantController@showSteps');

Route::post('/serwisant/updatestep/{id}','Serwisant\SerwisantController@updatestep');

Route::delete('/serwisant/deleteStep/{id}','Serwisant\SerwisantController@deleteStep');

Route::get('/serwisant/showRepair/{id}','Serwisant\SerwisantController@showRepair');

Route::post('/serwisant/editRepair/{id}','Serwisant\SerwisantController@editRepair');

Route::post('/serwisant/endRepair/{id}','Serwisant\SerwisantController@endRepair');


