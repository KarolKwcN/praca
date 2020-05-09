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

Route::get('/', function () {
    return view('home');
});

Auth::routes(['verify' => true]);

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');


Route::get('/admin', [
    'uses' => 'Admin\AdminController@getAdminPage',
    'as' => 'admin',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);


Route::get('api/ShowUser', [
    'uses' => 'Admin\AdminController@viewUser',
    'as' => 'admin',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::delete('api/DeleteUser/{id}', [
    'uses' => 'Admin\AdminController@destroy',
    'as' => 'admin',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);


Route::delete('api/AddSerwisant/{id}', [
    'uses' => 'Admin\AdminController@addSerwisant',
    'as' => 'admin',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::delete('api/AddAdmin/{id}', [
    'uses' => 'Admin\AdminController@addAdmin',
    'as' => 'admin',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::delete('api/DeleteAdmin/{id}', [
    'uses' => 'Admin\AdminController@deleteAdmin',
    'as' => 'admin',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::delete('api/DeleteSerwisant/{id}', [
    'uses' => 'Admin\AdminController@deleteSerwisant',
    'as' => 'admin',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::delete('api/DeleteBan/{id}', [
    'uses' => 'Admin\AdminController@deleteBan',
    'as' => 'admin',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::delete('api/AddBan/{id}', [
    'uses' => 'Admin\AdminController@addBan',
    'as' => 'admin',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/admin/naprawy', [
    'uses' => 'Admin\AdminController@getAdminRepairPage',
    'as' => 'admin.repairs',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::post('api/admin/addCategory', [
    'uses' => 'Admin\AdminController@addCategory',
    'as' => 'admin.repairs',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/api/admin/showCategory', [
    'uses' => 'Admin\AdminController@showCategory',
    'as' => 'admin.repairs',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::delete('api/admin/deleteCategory/{id}', [
    'uses' => 'Admin\AdminController@deleteCategory',
    'as' => 'admin.repairs',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::put('api/admin/updateCategory/{id}', [
    'uses' => 'Admin\AdminController@updateCategory',
    'as' => 'admin.repairs',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);


Route::get('/admin/naprawy/{slug}', [
    'uses' => 'Admin\AdminController@getAdminNaprawyMarkaPage',
    'as' => 'admin.repairs.marka',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/api/admin/showBrands/{id}', [
    'uses' => 'Admin\AdminController@showBrands',
    'as' => 'admin.repairs.marka',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);


Route::delete('api/admin/deleteBrand/{id}', [
    'uses' => 'Admin\AdminController@deleteBrand',
    'as' => 'admin.repairs.marka',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::put('api/admin/updateBrand/{id}', [
    'uses' => 'Admin\AdminController@updateBrand',
    'as' => 'admin.repairs.marka',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::post('api/admin/addBrand/{id}', [
    'uses' => 'Admin\AdminController@addBrand',
    'as' => 'admin.repairs.marka',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/api/admin/categoryName/{id}', [
    'uses' => 'Admin\AdminController@categoryName',
    'as' => 'admin.repairs.marka',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/admin/naprawy/{slug}/{slugi}', [
    'uses' => 'Admin\AdminController@getAdminNaprawyDevicePage',
    'as' => 'admin.repairs.device',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/api/admin/showDevices/{id}', [
    'uses' => 'Admin\AdminController@showDevices',
    'as' => 'admin.repairs.device',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);


Route::delete('api/admin/deleteDevice/{id}', [
    'uses' => 'Admin\AdminController@deleteDevice',
    'as' => 'admin.repairs.device',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::put('api/admin/updateDevice/{id}', [
    'uses' => 'Admin\AdminController@updateDevice',
    'as' => 'admin.repairs.device',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::post('api/admin/addDevice/{id}', [
    'uses' => 'Admin\AdminController@addDevice',
    'as' => 'admin.repairs.device',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

//////////////////////////////////////////SERWISANT

Route::get('serwisant', [
    'uses' => 'Serwisant\SerwisantController@index',
    'as' => 'serwisant.serwisant',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::get('serwisant/naprawa/{device}/{slugi_repair}', [
    'uses' => 'Serwisant\SerwisantController@getSerwisantNaprawa',
    'as' => 'serwisant.naprawa',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::get('serwisant/{slug}', [
    'uses' => 'Serwisant\SerwisantController@getSerwisantNaprawyMarkaPage',
    'as' => 'serwisant_naprawy_marka',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::get('serwisant/{slug}/{slugi}', [
    'uses' => 'Serwisant\SerwisantController@getSerwisantNaprawyModelPage',
    'as' => 'serwisant_naprawy_model',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::get('serwisant/{slug}/{slugi}/{slugii}', [
    'uses' => 'Serwisant\SerwisantController@getSerwisantUrzadzenie',
    'as' => 'serwisant_urzadzenie',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);



Route::post('api/serwisant/addRepair/{id}', [
    'uses' => 'Serwisant\SerwisantController@addRepair',
    'as' => 'serwisant.repairs',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::get('/api/serwisant/showRepairs/{id}', [
    'uses' => 'Serwisant\SerwisantController@showRepairs',
    'as' => 'serwisant.showrepairs',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::get('serwisant/naprawa/{device}/{slugi_repair}', [
    'uses' => 'Serwisant\SerwisantController@getSerwisantNaprawa',
    'as' => 'serwisant.naprawa',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);


Route::post('api/serwisant/naprawa/step/{id}', [
    'uses' => 'Serwisant\SerwisantController@addStepRepair',
    'as' => 'serwisant.addstep',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::post('api/serwisant/showSteps/{id}', [
    'uses' => 'Serwisant\SerwisantController@showSteps',
    'as' => 'serwisant.addstep',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);



