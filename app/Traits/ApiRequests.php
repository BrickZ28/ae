<?php

namespace App\Traits;

use App\Models\Server;
use Illuminate\Support\Facades\Http;

trait ApiRequests
{
    public function getApiRequest($token = null, $headers = [], $endpoint = null)
    {
        $token = config('constants.nitrado.api_token');
        $endpointurl = 'https://api.nitrado.net/' . $endpoint;
        $heads = ['application/json'];


        $response = Http::withToken($token)
            ->accept($heads)
            ->get($endpointurl);

        if ($response->successful()) {
            return $response->json();
        } else {
            // Handle the case when the API request fails
            return null;
        }
    }

    public function getOnlinePlayerCount()
    {
        $servers = Server::getFromAPI();

        // Initialize total players count
        $totalPlayers = 0;

        // Loop through each server
        foreach ($servers['data']['services'] as $server) {
            // Get game server data for the current server ID
            $serverData = $this->getApiRequest(null,null,"services/{$server['id']}/gameservers");

            $totalPlayers = $totalPlayers + $serverData['data']['gameserver']['query']['player_current'];

        }

        // Return the total number of players across all servers
        return $totalPlayers;

    }
}
