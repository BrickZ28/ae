<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTransactionJob;
use App\Models\Transaction;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {

        return view('dashboard.users.index')->with([
            'users' => User::with('userProfile')->get(),
            'filters' => ['id', 'username', 'role', 'Tribe', 'Last Login', 'Joined', 'actions'],
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
            'ae_credits' => 'nullable|numeric',
            'reason' => 'nullable|string|max:255',
        ], [
            'ae_credits.required_if' => 'The credits field is required when ae_credits is not 0 or blank.',
            'reason.required_if' => 'The reason field is required when credits is not 0 or blank.',
        ]);

        if ($request->ae_credits > 0 || $request->ae_credits < 0) {
            $user->update([
                'ae_credits' => $user->ae_credits + $request->ae_credits,
            ]);
            ProcessTransactionJob::dispatch(Auth::id(), $user->id, $request->ae_credits, $request->reason);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function transactionHistory($id)
{
    $user = User::with('transactions.item', 'transactions.package')->find($id);
    $filters = ['id', 'amount', 'reason', 'item', 'created_at', 'type', 'view'];

    return view('dashboard.users.transactions.index', compact( 'filters', 'user'));
}

}
