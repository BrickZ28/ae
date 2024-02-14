<?php

namespace App\Services;


use App\Traits\Responses\HttpResponses;
use Illuminate\Support\Facades\Http;

class ApiService
{
    use HttpResponses;
    public function fetchJsonDataArray($token, $url, $headers = ['application/json'])
    {
        // Make API request
        $response = Http::withToken($token)
            ->accept($headers)
            ->get($url);

        $data = json_decode($response, true);



        // Check if request was successful
        if ($data['status'] === 'success') {
                return $data;
            } else {
            return $this->error($data, $data['message'], 503);
        }

    }

    // Add more methods as needed for different API endpoints or operations
}
