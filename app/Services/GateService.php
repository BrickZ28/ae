<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Gate;
use App\Models\Item;
use App\Models\Playstyle;
use App\Models\User;
use Carbon\Carbon;
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
    protected $userService;

    public function __construct(DiscordService $discordService, UserService $userService)
    {
        $this->discordService = $discordService;
        $this->userService = $userService;
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
        $starter = Item::where('name', 'Starter Kit')->first()->id;

        //TODO mark gate as picked up


        // Define the validation rules
        $rules = [
            'gate_id' => 'required',
            'pin' => ['nullable', 'digits:4'],
        ];

//    TODO fix it with the correct validation rules for chaning users and pin
        // Check if the 'contents' or 'player' fields are being changed
//        if ($request->player !== $originalPlayer) {
//            // Add a rule to check if the 'pin' is the same as the old one
//            $rules['pin'][] = Rule::notIn([$gate->pin]);
//            $rules['pin'][] = 'required';
//        }

        // Validate the request
        $validatedData = $request->validate($rules);

        // Check if 'feed' is 1 or if the contents have changed
        if ($request->feed === '1' || $request->contents !== $gate->contents) {
            $validatedData['last_fed'] = Carbon::now();
        }

        //If its a starter kit and is being assigned we need to update the user starter kit based on their initail role
        if (($request->contents == $starter) && $request->player) {
            $user = User::find($request->player);
            $gate_converted = $this->convertGateToPlaystyleGame($gate);

            $this->userService->updateStartKit($user, $gate_converted);
        }

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

    public function issueGate($contents, $socialiteUser, $game)
    {
        $discordId = $socialiteUser->id; // Get the Discord ID
        $user = User::where('discord_id', $discordId)->first();

        $game = strtoupper($game);

        // Insert a space before each uppercase letter except the first one
        $part1 = substr($game, 0, 3); // 'ase'
        $part2 = substr($game, 3, 3); // 'pve'

// Convert each part to uppercase and join them with a space
        $game = strtoupper($part1) . ' ' . strtoupper($part2);



        if ($contents === 'starter') {
            $gate = $this->getStarterGate($socialiteUser);
        }
//TODO logic for order content
        if ($user && $gate) {
            // If the user exists and the gate is available and has a starter kit
            $gate->update(['player_id' => $user->id]);
            $this->userService->updateStartKit($user, $game);

            $message = "You have been assigned a new gate from AfterEarth Gaming\n\n"
                . "Here is your gate and pin information:\n\n"
                . "```css\n" // Start of code block with CSS syntax highlighting
                . "Gate ID: " . $gate->gate_id . "\n" // Gate ID will be displayed in color
                . "Pin: " . $gate->pin . "\n" // Pin will be displayed in color
                . "```\n\n" // End of code block
                . "You will find the gate and pin at the community center located at lat: 89.4  long: 40.8."; // New paragraph
            $this->discordService->sendMessage($discordId, $message);
        } else {
            $message = "OH No it looks like all the gates are full or empty at this time.\n\n"
                . "A message has been sent to the admin to fix this.  Once they have you will be notified will your gate details\n\n"; // New paragraph
            $this->discordService->sendMessage($discordId, $message);
            $this->discordService->sendMessage(190198403420913674, "$user->username has joined the server "
                . "and needs an $game gate assigned to them as none were available");

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

    public function getGatesNotFedInSevenDays()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);
        return Gate::with('game', 'playstyle')->where('last_fed', '<=', $sevenDaysAgo)->get();
    }

   private function convertGateToPlaystyleGame($gate)
{
    // Convert api_name and playstyle to lowercase
    $api_name = strtolower($gate->game->api_name);
    $playstyle = strtolower($gate->playstyle->name);


    // Check if the game's api_name contains 'evolved' or 'ascended' and check the playstyle
    if (str_contains($api_name, 'evolved') && $playstyle === 'pve') {
        return 'asepve';
    } elseif (str_contains($api_name, 'evolved') && $playstyle === 'pvp') {
        return 'asepvp';
    } elseif (str_contains($api_name, 'ascended') && $playstyle === 'pve') {
        return 'asapve';
    } elseif (str_contains($api_name, 'ascended') && $playstyle === 'pvp') {
        return 'asapvp';
    }

    // Return null if no match found
    return null;
}


}
