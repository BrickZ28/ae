<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.users.index')->with([
            'users' => User::all(),
            'filters' => ['username', 'role', 'last login', 'registered on']
        ]);
    }
}
