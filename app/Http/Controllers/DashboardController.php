<?php

namespace App\Http\Controllers;

use App\Models\Gate;
use App\Models\Transaction;
use App\Models\User;
use App\Services\GateService;
use Carbon\Carbon;
use DB;

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
        $currentMonth = Carbon::now();
        $monthly_transactions = Transaction::where('currency_type', 'USD')
            ->whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->get();

        $usd_in = $monthly_transactions->sum('amount');


        $goal_left = round((1200 - $usd_in) / (1200 * 100), 2);
        if ($goal_left < 50) {
            $badge = 'danger';
        } elseif ($goal_left < 75 && $goal_left >= 50) {
            $badge = 'warning';
        } else {
            $badge = 'success';
        }

        $last_transactions = Transaction::latest()
    ->distinct('payer_id')
    ->where('currency_type', 'USD')
    ->take(3)
    ->with(['payer', 'payer.userProfile']) // Include payer.userProfile relation
    ->get();




        return view('dashboard.index',
            compact('badge', 'usd_in', 'cartIsEmpty', 'users', 'hungry_dinos', 'goal_left',
                'monthly_transactions', 'last_transactions'));
    }

    public function playOptions()
    {
        return view('dashboard.play-options');
    }

}
