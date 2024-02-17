<?php

namespace App\Traits;

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
}
