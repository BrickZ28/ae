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

class GateService
{
    protected $discordService;
    protected $userService;

    public function __construct(DiscordService $discordService, UserService $userService)
    {
        $this->discordService = $discordService;
        $this->userService = $userService;
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

    public function validate($data)
    {
        $validator = Validator::make($data, [
            'gate_id' => 'required',
            'pin' => 'nullable|numeric',
            'playstyle' => 'required:playstyles,id',
            'game' => 'required:games,id',
            'player_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function updateGate($request, $gate)
    {
        $starter = Item::where('name', 'Starter Kit')->first()->id;

        //TODO mark gate as picked up Will require bot for discord


        $data = $request->all();

        // Check if 'player' is set to 'remove'
        if ($request->player_id === 'remove') {
            $data['player_id'] = null; // Unassign the gate
        } else if ($request->player_id) {
            $data['player_id'] = $request->player_id; // Assign the gate to the new player
        }

        // Define the validation rules
        $rules = [
            'gate_id' => 'required',
            'pin' => ['nullable', 'digits:4'],
            'player_id' => ['nullable', Rule::exists('users', 'id')],
        ];

        // Create a validator instance
        $validator = Validator::make($data, $rules);

        // Conditionally add the 'exists' rule for 'player_id'
        $validator->sometimes('player_id', 'exists:users,id', function ($input) {
            return $input->player_id !== 'remove';
        });

        // Validate the request
        $validatedData = $validator->validate();


        // Check if 'feed' is 1 or if the contents have changed
        if ($request->feed === '1' || $request->contents !== $gate->contents) {
            $validatedData['last_fed'] = Carbon::now();
        }

        //If its a starter kit and is being assigned we need to update the user starter kit based on their initail role
        if ((int)$request->contents === $starter && $request->player_id) {

            $user = User::find($request->player_id);
            $gate_converted = $this->convertGateToPlaystyleGame($gate);
            $this->userService->updateStartKit($user, $gate_converted);
            $this->issueGate('starter', $user->discord_id, $gate_converted);
        }

        // Update the gate
        $validatedData['admin_id'] = \Auth::id(); // Get the ID of the authenticated user

        $gate->update($validatedData);

        if ($request->contents) {
            if (is_string($request->contents) && is_array(json_decode($request->contents, true)) && (json_last_error() == JSON_ERROR_NONE)) {
                $contents = json_decode($request->contents, true);
                $gate->items()->sync($contents);
            } else {
                $gate->items()->sync([$request->contents]);
            }
        } else {
            $gate->items()->detach();
        }
        return $gate;
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

    public function issueGate($contents, $socialiteUser, $game)
    {

        $user = User::where('discord_id', $socialiteUser)->first();

        $game = strtoupper($game);

        // Insert a space before each uppercase letter except the first one
        $part1 = substr($game, 0, 3); // 'ase'
        $part2 = substr($game, 3, 3); // 'pve'

// Convert each part to uppercase and join them with a space
        $game = strtoupper($part1) . ' ' . strtoupper($part2);


        if ($contents === 'starter') {
            $gate = $this->getStarterGate();
        }

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
            $this->discordService->sendMessage($socialiteUser, $message);
        } else {
            $message = "OH No it looks like all the gates are full or empty at this time.\n\n"
                . "A message has been sent to the admin to fix this.  Once they have you will be notified will your gate details\n\n"; // New paragraph
            $this->discordService->sendMessage($socialiteUser, $message);
            $this->discordService->sendMessage(190198403420913674, "$user->username has joined the server " //TODO
                // change this to K
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

    public function getGatesNotFedInSevenDays()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);
        return Gate::with('game', 'playstyle')->where('last_fed', '<=', $sevenDaysAgo)->get();
    }


}
