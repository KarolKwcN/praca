<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
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
       $user = User::with('roles')->get();
      /* $user = DB::table('users')->select('users.id','users.name','users.email','user_role.role_id')->
       join('user_role','user_role.user_id','=','users.id')->get();*/
    	return $user;
    	
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        //usuwanie roli usunietego uzytkownika
        DB::table('user_role')->where('user_id', '=', $id)->delete();
    
        return ['message' => 'User Deleted'];
    }

    public function addSerwisant($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->attach(Role::where('name', 'Serwisant')->first());

        return ['message' => 'Rola serwisant dodana.'];
    }

    public function addAdmin($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->attach(Role::where('name', 'Admin')->first());

        return ['message' => 'Rola admin dodana.'];
    }

    public function deleteAdmin($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->detach(Role::where('name', 'Admin')->first());

        return ['message' => 'Rola admin usunięta.'];
    }

    public function deleteSerwisant($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->detach(Role::where('name', 'Serwisant')->first());

        return ['message' => 'Rola serwisant usunięta.'];
    }
}
