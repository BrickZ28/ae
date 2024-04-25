<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Gate;
use App\Models\Item;
use App\Models\Playstyle;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;
use Request;

class GateService
{
    protected $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }

    public function validate($data)
    {
        $validator = Validator::make($data, [
            'gate_id' => 'required',
            'pin' => 'nullable|numeric',
            'playstyle' => 'required:playstyles,id',
            'game' => 'required:games,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }


    public function createGate($data)
    {
        // Logic for creating a gate
        $gate = Gate::create($data);
        return $gate;
    }

    public function storeGate($request)
    {
        $this->validate($request->all());

        try {
            if (Gate::create([
                'gate_id' => $request->gate_id,
                'pin' => $request->pin,
                'playstyle_id' => $request->playstyle,
                'game_id' => $request->game,
                'admin_id' => Auth::id(),
            ])) {
                Alert::success('Rule Created', 'New gate created successfully');
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

    public function updateGate($request, $gate)
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
        $validatedData['admin_id'] = \Auth::id(); // Get the ID of the authenticated user

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
        return $gate;
    }

    public function attachItemsToGate(Gate $gate, $contents)
    { //TODO get orders all working and check this method
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

    public function getGatesByGameAndStyle($game, $style)
    {
        $game_id = Game::where('display_name', $game)->first()->id;
        $style_id = Playstyle::where('name', $style)->first()->id;
        return Gate::with(['player', 'admin', 'playstyle'])
            ->where('game_id', $game_id)
            ->where('playstyle_id', $style_id)
            ->get();
    }

    public function issueGate($contents, $user)
    {

        if ($contents === 'starter') {
            $gate = $this->getStarterGate($user);
        }

        $discordId = $user->id; // Get the Discord ID
        $user = User::where('discord_id', $discordId)->first();


        if ($user && $gate) {
            // If the user exists and the gate is available and has a starter kit
            $gate->update(['player_id' => $user->id]);

            $message = "You have been assigned a new gate from AfterEarth Gaming\n\n"
            ."Here is your gate and pin information:\n\n"
                . "```css\n" // Start of code block with CSS syntax highlighting
                . "Gate ID: " . $gate->gate_id . "\n" // Gate ID will be displayed in color
                . "Pin: " . $gate->pin . "\n" // Pin will be displayed in color
                . "```\n\n" // End of code block
                . "You will find the gate and pin at the community center."; // New paragraph
            $this->discordService->sendMessage($discordId, $message);
        } else {
            dd('No gates available or user not found');
            //        TODO logic to catch no gate
        }
    }

    private function getStarterGate()
    {
        $starterKitId = Item::where('name', 'Starter Kit')->first()->id;

        $gatesWithStarterKit = Gate::whereHas('items', function ($query) use ($starterKitId) {
            $query->where('item_id', $starterKitId);
        })->get();

        $gate = $gatesWithStarterKit->first(function ($gate) {
            return $gate->player == null;
        });

        return $gate;

    }


}
