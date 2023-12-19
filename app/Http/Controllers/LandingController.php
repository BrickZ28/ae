<?php

namespace App\Http\Controllers;

use App\DataTables\UsersAssignedRoleDataTable;
use App\Models\User;

class LandingController extends Controller
{
	public function index()
	{
        $users = User::all();

		return view('landing.master')->with('users', $users);
	}
}
