<?php

namespace App\Traits;

use App\Models\Server;
use Illuminate\Support\Facades\Http;

trait ApiRequests
{
    /**
     * Make an API request.
     *
     * @param string $endpoint
     * @param array|null $headers
     * @param string|null $token
     * @return mixed
     */
    public function getApiRequest(string $endpoint, ?string $token = null, ?array $headers = [])
    {
        // Initialize the HTTP client and optionally add the Authorization header for the token
        $request = Http::withHeaders(array_merge($headers, $token ? ['Authorization' => 'Bearer ' . $token] : []));

        // Execute the GET request to the endpoint
        $response = $request->get($endpoint);

        // Return the entire HTTP response
        return $response;
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
