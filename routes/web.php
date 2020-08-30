<?php

use Illuminate\Support\Facades\Route;
use App\Repair;
use App\ImageStep;
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
     $repair = Repair::with('steps')->where('accept', '1')->orderBY('id','desc')->first();

     $step_id = $repair->steps[0]->id;

    $images = ImageStep::where('step_id', $step_id)->orderBY('id', 'asc')->get();

    

        return view('home', compact('repair', 'images'));
    
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
    'as' => 'admin.addcategory',
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

Route::post('api/admin/updateCategory/{id}', [
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

Route::post('api/admin/updateBrand/{id}', [
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

Route::get('/admin/naprawy/{slug}/{slugi}/{slugii}', [
    'uses' => 'Admin\AdminController@getAdminRepiarsDevice',
    'as' => 'admin.repairs.devicerepairs',
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

Route::post('api/admin/updateDevice/{id}', [
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
Route::get('api/admin/showDeviceRepairs/{id}', [
    'uses' => 'Admin\AdminController@showDeviceRepairs',
    'as' => 'admin.repairs.device',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::put('api/admin/akceptujnaprawe/{id}', [
    'uses' => 'Admin\AdminController@akceptujnaprawe',
    'as' => 'admin.accept.repair',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::put('api/admin/odrzucnaprawe/{id}', [
    'uses' => 'Admin\AdminController@odrzucnaprawe',
    'as' => 'admin.unaccept.repair',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::put('api/admin/przekazdorealziacji/{id}', [
    'uses' => 'Admin\AdminController@przekazdorealziacji',
    'as' => 'admin.status.realizacja',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);


Route::delete('api/deleteRepair/{id}', [
    'uses' => 'Admin\AdminController@deleteRepair',
    'as' => 'admin.delete.repair',
    'middleware' => 'roles',
    'roles' => ['Admin', 'Serwisant']
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

Route::get('serwisant/naprawa/{device}/{id}/{slugi_repair}', [
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


Route::post('api/serwisant/updatestep/{id}', [
    'uses' => 'Serwisant\SerwisantController@updatestep',
    'as' => 'serwisant.updatestep',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::delete('api/serwisant/deleteStep/{id}', [
    'uses' => 'Serwisant\SerwisantController@deleteStep',
    'as' => 'serwisant.deleteStep',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::get('/api/serwisant/showRepair/{id}', [
    'uses' => 'Serwisant\SerwisantController@showRepair',
    'as' => 'serwisant.showRepair',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::post('api/serwisant/editRepair/{id}', [
    'uses' => 'Serwisant\SerwisantController@editRepair',
    'as' => 'serwisant.editRepair',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::post('api/serwisant/endRepair/{id}', [
    'uses' => 'Serwisant\SerwisantController@endRepair',
    'as' => 'serwisant.endRepair',
    'middleware' => 'roles',
    'roles' => ['Serwisant']
]);

Route::get('naprawa/{slug}/{slugi}/{slugii}/{id}/{slugi_name}', [
    'uses' => 'NaprawaController@getNaprawa',
    'as' => 'naprawa',
]);

////////////////////////////////////////////////////////

Route::get('/naprawy', function(){
    $categorie = DB::table('categories')
        ->join('brands', 'categories.id', '=', 'brands.category_id')
        ->join('devices', 'brands.id', '=', 'devices.brand_id')
        ->join('repairs', 'devices.id', '=' , 'repairs.device_id')
        ->where('repairs.accept', '=',1)
        ->select('categories.*')->get();

        $categories = $categorie->unique();

    return view('naprawa.naprawy_kategorie', ['categories' => $categories]);
});

Route::get('/naprawy/{slug}',[
    'uses' => 'PageController@getMarka',
    'as' => 'naprawa.marka',
]);

Route::get('/naprawy/{slug}/{slugi}',[
    'uses' => 'PageController@getDevice',
    'as' => 'naprawa.device',
]);

Route::get('/naprawy/{slug}/{slugi}/{slugii}',[
    'uses' => 'PageController@getRepairs',
    'as' => 'naprawa.repairs',
]);

Route::post('api/addComment/{id}',[
    'uses' => 'PageController@addComment',
    'as' => 'addComment',
]);

Route::get('/wiadomosci', function(){
    return view('wiadomosci');
})->middleware('verified');

Route::get('/getMessages',[
    'uses' => 'MessageController@getMessages',
    'as' => 'messages.getmessages',
])->middleware('verified');

Route::get('api/getMessages/{id}',[
    'uses' => 'MessageController@getMessagesID',
    'as' => 'messages.getmessagesid',
])->middleware('verified');

Route::post('/sendMessage', 'MessageController@sendMessage')->middleware('verified');

Route::get('/getUsers', 'MessageController@getUsers')->middleware('verified');

Route::post('/sendNewMessage', 'MessageController@sendNewMessage')->middleware('verified');


Route::get('/Wyszukane', [
    'uses' => 'PageController@szukaj',
    'as' => 'wyszukaj.naprawe',
]);

Route::get('api/messagecount','MessageController@getCount');

Route::get('api/countmessages/{id}','MessageController@getCountmessages');
        

Route::get('/kontakt', function(){
    return view('kontakt');
});

Route::get('/onas', function(){
    return view('onas');
});
