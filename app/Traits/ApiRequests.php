<?php

namespace App\Traits;

use App\Models\Server;
use Illuminate\Support\Facades\Http;

trait ApiRequests
{
    public function getApiRequest($token = null, $headers = null, $endpoint = null)
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

    public function getOnlinePlayerCOunt()
    {
        $servers = Server::getFromAPI();

        // Initialize total players count
        $totalPlayers = 0;

        // Loop through each server
        foreach ($servers['data']['services'] as $server) {
            // Get game server data for the current server ID
            $serverData = $this->getApiRequest(null,null,"services/{$server['id']}/gameservers/games/players");

            foreach ($serverData['data']['players'] as $player){
                if ($player['online']){
                    $totalPlayers++;
                }
            }
            // Check if player data exists for the current server

        }
        // Return the total number of players across all servers
        return "Total players across all servers: $totalPlayers";

    }
}
