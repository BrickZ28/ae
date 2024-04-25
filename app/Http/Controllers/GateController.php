<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Item;
use App\Models\Order;
use App\Models\Playstyle;
use App\Models\User;
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
    $this->validate($request, [
        'gate_id' => 'required',
        'pin' => 'nullable|numeric',
        'playstyle' => 'required:playstyles,id',
        'game' => 'required:games,id',
    ]);

    try {
        if (Gate::create([
            'gate_id' => $request->gate_id,
            'pin' => $request->pin,
            'playstyle_id' => $request->playstyle,
            'game_id' => $request->game,
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
    // Get the original values
    $originalPlayer = $gate->player;

    // Define the validation rules
    $rules = [
        'gate_id' => 'required',
        'pin' => ['nullable', 'digits:4'],
    ];

//    TODO fix it with the correct validation rules for chaning users and pin
    // Check if the 'contents' or 'player' fields are being changed
    if ($request->player !== $originalPlayer) {
        // Add a rule to check if the 'pin' is the same as the old one
        $rules['pin'][] = Rule::notIn([$gate->pin]);
        $rules['pin'][] = 'required';
    }

    // Validate the request
    $validatedData = $request->validate($rules);

    // Update the gate
    $validatedData['admin_id'] = Auth::id(); // Get the ID of the authenticated user

    $gate->update($validatedData);

    if ($request->contents) {
        // Check if contents is a JSON string
        if (is_string($request->contents) && is_array(json_decode($request->contents, true)) && (json_last_error() == JSON_ERROR_NONE)) {
            // Decode the JSON string into an array
            $contents = json_decode($request->contents, true);

            // Iterate over the array and attach each item to the gate
            foreach ($contents as $itemId) {
                $gate->items()->attach($itemId);
            }
        } else {
            // Attach the single item to the gate
            $gate->items()->attach($request->contents);
        }
    }

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
        $game_id = Game::where('display_name', $game)->first()->id;
        $style_id = Playstyle::where('name', $style)->first()->id;
        $gates = Gate::with(['player', 'admin', 'playstyle'])
            ->where('game_id', $game_id)
            ->where('playstyle_id', $style_id)
            ->get();

        $filters = ['id', 'pin', 'assigned to', 'playstyle', 'last fed', 'edited by', 'edit'];
        return view('dashboard.gates.index', compact('gates', 'filters'));
    }
}
