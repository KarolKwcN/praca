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
