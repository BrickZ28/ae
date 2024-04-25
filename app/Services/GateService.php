<?php

namespace App\Services;

use App\Models\Gate;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class GateService
{
    public function createGate($data)
    {
        // Logic for creating a gate
        $gate = Gate::create($data);
        return $gate;
    }

    public function storeGate($request)
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
    }

    public function updateGate(Gate $gate, $data)
    {
        // Logic for updating a gate
        $data['admin_id'] = Auth::id(); // Get the ID of the authenticated user
        $gate->update($data);
        return $gate;
    }

    public function attachItemsToGate(Gate $gate, $contents)
    {
        // Logic for attaching items to a gate
        if (is_string($contents) && is_array(json_decode($contents, true)) && (json_last_error() == JSON_ERROR_NONE)) {
            // Decode the JSON string into an array
            $contents = json_decode($contents, true);

            // Iterate over the array and attach each item to the gate
            foreach ($contents as $itemId) {
                $gate->items()->attach($itemId);
            }
        } else {
            // Attach the single item to the gate
            $gate->items()->attach($contents);
        }
    }

    public function deleteGate(Gate $gate)
    {
        // Logic for deleting a gate
        $gate->delete();
    }
}
