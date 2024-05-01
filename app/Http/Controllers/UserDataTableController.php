<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserDataTableController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function getUsersData()
    {
        $data = User::select(['id', 'username', 'email', 'created_at', 'updated_at']);
        return DataTables::of($data)->make(true);
    }
}
