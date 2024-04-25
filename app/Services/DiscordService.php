<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;

class DiscordService
{  //TODO create a method or class to handle messages to discord
    protected $botToken;

    protected $guildId;

    protected $apiBase;

    public function __construct()
    {
        $this->botToken = env('DISCORD_API_BOT_TOKEN');
        $this->guildId = env('DISCORD_GUILD_ID');
        $this->apiBase = 'https://discord.com/api/v10/';
    }

    public function assignDiscordRole($userId, $roleId)
    {

        $endpoint = "{$this->apiBase}guilds/{$this->guildId}/members/{$userId}/roles/{$roleId}";
        $response = Http::withHeaders(['Authorization' => 'Bot ' . $this->botToken])->put($endpoint);
        return $response->successful();
    }

    public function fetchUserRoles($userId)
    {
        $endpoint = "{$this->apiBase}guilds/{$this->guildId}/members/{$userId}";
        $response = $this->makeRequest($endpoint);

        return $response->successful() ? $response->json()['roles'] ?? [] : [];
    }

    public function syncUserRoles($userId, $roles)
    {
        $user = User::where('discord_id', $userId)->first();
        if (!$user) {
            return; // Consider logging this situation or throwing an exception
        }

        $existingRoles = Role::whereIn('role_id', $roles)->get();
        $user->roles()->sync($existingRoles->pluck('id')->toArray());

    }

    public function syncDiscordRoles()
    {
        $endpoint = "{$this->apiBase}guilds/{$this->guildId}/roles";
        $response = $this->makeRequest($endpoint);

        if ($response->successful()) {
            $roles = $response->json();
            foreach ($roles as $role) {
                // Store the original role name
                $discord_name = $role['name'];

                // Remove special characters from the role name
                $sanitizedRoleName = preg_replace('/[^A-Za-z0-9 ]/', '', $role['name']);

                Role::updateOrCreate(
                    ['role_id' => $role['id']],
                    ['role_name' => $sanitizedRoleName, 'discord_name' => $discord_name]
                );
            }
        } elseif ($response->failed()) {
            // Handle any failed request (not in the 200-299 range)
            $error = $response->json();
            $statusCode = $response->status();

            return redirect()->route('dashboard.index')->with('error', "Request failed with status $statusCode: ", $error);
        }

        return redirect()->route('dashboard.index')->with('success', 'Roles added successfully');
    }

    protected function makeRequest($endpoint)
    {
        $headers = ['Authorization' => 'Bot ' . $this->botToken];

        return Http::withHeaders($headers)->get($endpoint);
    }

    public function newUserDiscordSetup($request, $user)
    {

        //determine game and style
        $role = $this->determineGameAndStyle($request->game);


        //set discord role based on selection
        $this->assignDiscordRole($user->id, $role->role_id);

        // send welcome message in DM
        $this->sendMessage($user->id, $this->welcomeMessage($user, $role, $request));

        return $role;
    }

    private function welcomeMessage($user, $role, $request)
    {

        if ($request->game === 'asepve' || $request->game === 'asepvp') {
            $kit_msg = "If you haven't received your starter pack details yet, please don't hesitate to let us know by "
            ."submitting a ticket, and we'll ensure you get everything you need to kickstart your adventure. "
            . "Should you wish to try another ASE playstyle, simply head over to your website dashboard and select "
            ."the playstyle you're interested in. Once you've made your choice, you'll receive a message with all the details of your starter pack\n\n";
        } else {
            $kit_msg = "As an ASA player, your starter pack will be automatically provided by the game server.  "
            ."If you do have issues when logging in for the first time with your starter kit, please don't hesitate to "
            . "let us know by submitting a ticket, and we'll ensure you get everything you need to kickstart your adventure.";
        }

        return  "Welcome to the AfterEarth Gaming Community, {$user->name}! We're thrilled to have you on board as a member. "
        . "Based on your preference, you have been designated the {$role->discord_name} player – an exciting choice! "
        . "If you haven't received your starter pack details yet, please don't hesitate to let us know by submitting a ticket, "
            ."and we'll ensure you get everything you need to kickstart your adventure.\n\n "
        . "Remember, you're not limited to just one server or playstyle. Feel free to explore our other servers as well. "
        . "Whether it's the ASA server or ASE, you'll find something to enjoy. "
            . $kit_msg

        . "Got any questions? Don't hesitate to ask in the general chat – we're here to help! "
        . "Enjoy your time with us, and may your gaming experiences be filled with excitement and fun!";
    }


    public function determineGameAndStyle($game)
    {
        // Define a mapping from game codes to role names
        $gameToRoleName = [
            'asapvp' => 'Ark Ascended PvP',
            'asapve' => 'Ark Ascended PvE',
            'asepvp' => 'Ark Evolved PvP',
            'asepve' => 'Ark Evolved PvE',
        ];

        // Check if the game code exists in the mapping
        if (!array_key_exists($game, $gameToRoleName)) {
            throw new Exception("Invalid game code: $game");
        }

        // Get the role name from the mapping
        $roleName = $gameToRoleName[$game];

        // Query the roles table for the role with the given name
        $role = Role::where('role_name', $roleName)->first();

        // If the role doesn't exist, throw an exception or handle the error as needed
        if (!$role) {
            throw new Exception("Role not found: $roleName");
        }

        // Return the role
        return $role;
    }

    public function sendMessage($userId, $message)
    {
        // Create a DM channel with the user
        $endpoint = "{$this->apiBase}users/@me/channels";
        $response = Http::withHeaders(['Authorization' => 'Bot ' . $this->botToken])
            ->post($endpoint, ['recipient_id' => $userId]);

        if (!$response->successful()) {
            throw new Exception("Failed to create DM channel: " . $response->body());
        }

        $dmChannel = $response->json();

        // Send a message to the DM channel
        $endpoint = "{$this->apiBase}channels/{$dmChannel['id']}/messages";
        $response = Http::withHeaders(['Authorization' => 'Bot ' . $this->botToken])
            ->post($endpoint, ['content' => $message]);

        if (!$response->successful()) {
            throw new Exception("Failed to send message: " . $response->body());
        }
    }


}
