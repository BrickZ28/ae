<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $cartIsEmpty = auth()->user() && auth()->user()->cart && auth()->user()->cart->items->isEmpty();
        $users = User::with('userProfile')->get();
        return view('dashboard.index', compact('cartIsEmpty', 'users'));
    }

    public function playOptions()
    {
        return view('dashboard.play-options');
    }
}
