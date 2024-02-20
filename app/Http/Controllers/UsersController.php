<?php
namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\ProcessTransactionJob;


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
            'reason' => 'required_if:ae_credits,>0|string|max:255'
        ]);

        $user->update([
            'ae_credits' => $request->ae_credits,
        ]);

        if($request->ae_credits > 0){
            ProcessTransactionJob::dispatch(Auth::id(), $user->id, $request->ae_credits, $request->reason);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}


