<?php

namespace App\Http\Controllers;

use App\Models\Gate;
use App\Models\User;
use App\Services\GateService;
use Carbon\Carbon;

class DashboardController extends Controller
{

    protected $gateService;

    public function __construct(GateService $gateService)
    {
        $this->gateService = $gateService;
    }


    public function index()
    {
        $cartIsEmpty = auth()->user() && auth()->user()->cart && auth()->user()->cart->items->isEmpty();
        $users = User::with('userProfile')->get();
        $hungry_dinos = $this->gateService->getGatesNotFedInSevenDays();
        return view('dashboard.index', compact('cartIsEmpty', 'users', 'hungry_dinos'));
    }

    public function playOptions()
    {
        return view('dashboard.play-options');
    }

}
