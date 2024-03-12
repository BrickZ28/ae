<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GamesController extends Controller
{
    public function index()
    {
        return view('dashboard.game.index')->with([
            'games' => Game::all(),
            'filters' => ['id', 'API Name', 'Display Name', 'Created On', 'Edit', 'Delete', 'Servers'],
        ]);
    }

    public function create()
    {
        return view('dashboard.game.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'api_name' => 'required',
            'display_name' => 'required',
        ]);

        if (Game::create([
            'api_name' => $request->api_name,
            'display_name' => $request->display_name,
        ])) {
            Alert::success('Success', 'New game added successfully');
        }

        return view('dashboard.index');
    }

    public function show(Game $game)
    {
    }

    public function edit(Game $game)
    {
        return view('dashboard.game.edit')->with([
            'game' => $game,
        ]);
    }

    public function update(Request $request, Game $game)
    {
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('dashboard.index')->with('success', 'Game deleted successfully');
    }
}
