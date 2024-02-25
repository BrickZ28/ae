<?php
// DiscordService.php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class DiscordService {
    protected $botToken;
    protected $guildId;
    protected $api_base;

    public function __construct() {
        $this->botToken = env('DISCORD_API_BOT_TOKEN');
        $this->guildId = env('DISCORD_GUILD_ID');
        $this->api_base = 'https://discord.com/api/v10/';

    }

    public function fetchUserRoles($userId) {
        $headers = ['Authorization' => 'Bot ' . $this->botToken];
        $endpoint = $this->api_base.$this->guildId."/members/{$userId}";
        $response = Http::withHeaders($headers)->get($endpoint);

        if ($response->successful()) {
            $userData = $response->json();
            return $userData['roles'] ?? [];
        }
        return $response->json();
    }

    public function syncUserRoles($userId, $roles) {
        // Assuming $roles is an array of role IDs fetched from Discord for the user
        $user = User::where('discord_id', $userId)->first();
        if (!$user) {
            return; // User not found, handle as appropriate
        }

        // Fetch all roles that exist in your database
        $existingRoles = Role::whereIn('role_id', $roles)->get();

        // Sync the user's roles
        $user->roles()->sync($existingRoles->pluck('id')->toArray());
    }

    public function syncDiscordRoles()
    {
        $headers = ['Authorization' => 'Bot ' . $this->botToken];
        $endpoint = $this->api_base."guilds/{$this->guildId}roles";

        $response = Http::withHeaders($headers)->get($endpoint);

        if ($response->successful()) {
            $userData = $response->json();
            return $userData['roles'] ?? [];
        }
        return $response->json();
    }
}
