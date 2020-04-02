<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function getAdminPage()
    {
    	$users = User::all();
    	return view('admin.admin', ['users' => $users]);
    }
}
