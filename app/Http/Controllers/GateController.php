<?php

namespace App\Http\Controllers;

use App\Models\Playstyle;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class GateController extends Controller
{
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
        return view('dashboard.gates.create', compact('play_styles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */


public function store(Request $request)
{
    $this->validate($request, [
        'gate_id' => 'required',
        'pin' => 'nullable|numeric',
        'playstyle' => 'required|exists:playstyles,id',
    ]);

    try {
        if (Gate::create([
            'gate_id' => $request->gate_id,
            'pin' => $request->pin,
            'playstyle_id' => $request->playstyle,
        ])) {
            Alert::success('Rule Created', 'New rule created successfully');
        }
    } catch (QueryException $e) {
        if ($e->getCode() == 23000) {
            // Handle duplicate entry error
            Alert::error('Duplicate Entry', 'A gate with the same ID and playstyle already exists.');
        } else {
            // Handle other SQL errors
            Alert::error('Database Error', 'An error occurred while creating the gate.');
        }
    }

    return redirect()->route('gates.index');
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
        $users = User::all();
        $playstyles = Playstyle::all();
        return view('dashboard.gates.edit', compact('gate', 'users', 'playstyles'));
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
        $gate->update($request->all());
        return redirect()->route('dashboard.gates.index');
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
}
