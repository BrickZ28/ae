<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Item;
use App\Models\Order;
use App\Models\Playstyle;
use App\Models\User;
use App\Services\GateService;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Gate;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class GateController extends Controller
{

    protected $gateService;

    public function __construct(GateService $gateService)
    {
        $this->gateService = $gateService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $gates = Gate::with(['player', 'admin', 'playstyle'])->get();
        $filters = ['id', 'pin', 'assigned to', 'playstyle', 'last fed', 'edited by', 'edit'];
        return view('dashboard.gates.index', compact('gates', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        $play_styles = Playstyle::all();
        $games = Game::all();
        return view('dashboard.gates.create', compact('play_styles', 'games'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */


public function store(Request $request)
{
    $this->gateService->storeGate($request);

    return redirect()->route('gates.index')->with('success', 'Gate created successfully');
}

    /**
     * Display the specified resource.
     *
     * @param Gate $gate
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Gate $gate)
    {
        return view('dashboard.gates.show', compact('gate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Gate $gate
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Gate $gate)
    {
        $starter = Item::where('name', 'Starter Kit')->first();
        $users = User::all();
        $orders = Order::all();
        return view('dashboard.gates.edit', compact('starter','gate', 'users', 'orders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Gate $gate
     * @return RedirectResponse
     */

public function update(Request $request, Gate $gate)
{
    $this->gateService->updateGate($request, $gate);

    return redirect(route('dashboard.index'))->with('success', 'Gate updated successfully');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param Gate $gate
     * @return RedirectResponse
     */
    public function destroy(Gate $gate)
    {
        $gate->delete();
        return redirect()->route('dashboard.gates.index');
    }

    public function getGates($game, $style)
    {
        $gates = $this->gateService->getGatesByGameAndStyle($game, $style);

        $filters = ['id', 'pin', 'assigned to', 'playstyle', 'last fed', 'edited by', 'edit'];
        return view('dashboard.gates.index', compact('gates', 'filters'));
    }
}
