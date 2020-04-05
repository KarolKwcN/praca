<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;

class AdminController extends Controller
{
    public function getAdminPage()
    {
    	//$users = User::all()->paginate(10);
    	return view('admin.admin');
    }

    public function viewUser()
    {
    	return User::all();
    	
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        //usuwanie roli usunietego uzytkownika
        DB::table('user_role')->where('user_id', '=', $id)->delete();
    
        return ['message' => 'User Deleted'];
    }
}
