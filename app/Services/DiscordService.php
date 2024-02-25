<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class DiscordService {
    protected $botToken;
    protected $guildId;
    protected $apiBase;

    public function __construct() {
        $this->botToken = env('DISCORD_API_BOT_TOKEN');
        $this->guildId = env('DISCORD_GUILD_ID');
        $this->apiBase = 'https://discord.com/api/v10/';
    }

    public function fetchUserRoles($userId) {
        $endpoint = "{$this->apiBase}guilds/{$this->guildId}/members/{$userId}";
        $response = $this->makeRequest($endpoint);

        return $response->successful() ? $response->json()['roles'] ?? [] : [];
    }

    public function syncUserRoles($userId, $roles) {
        $user = User::where('discord_id', $userId)->first();
        if (!$user) {
            return; // Consider logging this situation or throwing an exception
        }

        $existingRoles = Role::whereIn('role_id', $roles)->get();
        $user->roles()->sync($existingRoles->pluck('id')->toArray());
    }

    public function syncDiscordRoles() {
        $endpoint = "{$this->apiBase}guilds/{$this->guildId}/roles";
        $response = $this->makeRequest($endpoint);

        if ($response->successful()) {
            $roles = $response->json();
            foreach ($roles as $role) {
                Role::updateOrCreate(['role_id' => $role['id']], ['role_name' => $role['name']]);
            }
        }

        return redirect()->route('dashboard.index')->with('success', 'Roles added successfully');
    }

    protected function makeRequest($endpoint) {
        $headers = ['Authorization' => 'Bot ' . $this->botToken];
        return Http::withHeaders($headers)->get($endpoint);
    }
}
