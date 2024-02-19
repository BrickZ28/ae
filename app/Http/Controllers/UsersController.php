<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;


class UsersController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.users.index')->with([
            'users' => User::all(),
            'filters' => ['id','username', 'role', 'Tribe', 'Last Login', 'Joined', 'actions']
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        //check validation
        $request->validate([
            'ae_credits' => 'required_if:ae_credits,>0|numeric',
        ]);

        $user->update([
            'ae_credits' => $request->ae_credits,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}


