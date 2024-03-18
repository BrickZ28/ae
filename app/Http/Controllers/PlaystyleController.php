<?php

namespace App\Http\Controllers;

use App\Models\Playstyle;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PlaystyleController extends Controller
{
    public function index()
    {
        $styles = Playstyle::all();

        $filters = ['id', 'name', 'created_at', 'updated_at', 'edit', 'delete', 'servers'];

        return view('dashboard.playstyle.index', compact('styles', 'filters'));

    }

    public function create()
    {
        return view('dashboard.playstyle.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        // Create the server
        $styleCreated = Playstyle::firstOrCreate([
            'name' => $validatedData['name'],
        ]);

        // Check if server was created successfully
        if ($styleCreated) {
            Alert::success('Server Created', 'New server created successfully');
        }

        return redirect()->route('dashboard.index');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        return view('dashboard.playstyle.edit', ['style' => Playstyle::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        // Find the rule
        $style = Playstyle::find($id);

        // Update the rule with validated data
        $style->fill($validatedData);

        // Save the updated rule
        if ($style->save()) {
            Alert::success('Updated', 'Style Updated');
        } else {
            Alert::error('Failed', 'Style failed to update');
        }

        return view('dashboard.index');
    }

    public function destroy(Playstyle $playstyle)
    {
        $playstyle->delete();

        return redirect()->route('dashboard.index')->with('success', 'Style deleted successfully');
    }
}
