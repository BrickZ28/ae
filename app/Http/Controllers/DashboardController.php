<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $cartIsEmpty = auth()->user() && auth()->user()->cart && auth()->user()->cart->items->isEmpty();

        return view('dashboard.index', compact('cartIsEmpty'));
    }
}
