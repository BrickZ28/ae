<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payer_id' => 'required|exists:users,id',
            'payee_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ]);

        Transaction::create($request->all());

        return redirect()->route('dashboard.index')->with('success', 'Transaction created successfully');
    }
    public function show(Transaction $transaction)
    {
        return view('dashboard.transactions.show', compact('transaction'));
    }

}
