<?php

namespace App\Services;


use App\Traits\Responses\HttpResponses;
use Illuminate\Support\Facades\Http;

class ApiService
{
    use HttpResponses;
    public function fetchData($token, $url, $headers = ['application/json'])
    {
        // Make API request
        $response = Http::withToken($token)
            ->accept($headers)
            ->get($url);

        $data = $response->json();

        // Check if request was successful
        if ($data['status'] === 'success') {
                return $response->json();
            } else {
            return $this->error($data, $data['status'], 401);
        }

    }

    // Add more methods as needed for different API endpoints or operations
}
