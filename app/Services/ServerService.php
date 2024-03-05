<?php

namespace App\Services;

use App\Models\Server;
use App\Traits\ApiRequests;
use App\Traits\FileTrait;
use RealRashid\SweetAlert\Facades\Alert;

class ServerService
{
    use ApiRequests, FileTrait;

    public function getServersWithFilters()
    {
        // Retrieve servers from the API.
        $servers = Server::getFromAPI();

        // Define the filters.
        $filters = [
            'id',
            'name',
            'slots',
            'renew by',
            'status',
            'game',
            'actions',
        ];

        return compact('servers', 'filters');
    }

    public function createServer(array $data)
    {
        // Validate the request data
        $validatedData = $this->validateServerData($data);

        // Create the server
        if (Server::firstOrCreate([
            'name' => $validatedData['name'],
            'ip' => $data['ip'],
        ])) {
            Alert::success('Server Created', 'New server created successfully');
        }

        // You may return the newly created server instance or any other data you need
        return true;
    }

    protected function validateServerData(array $data)
    {
        return validator($data, [
            'name' => 'required',
        ])->validate();
    }

    public function getServerData($id)
    {
        $server = Server::where('serverhost_id', $id)->firstOrFail();
        $apiServer = $this->getApiServerData($server->serverhost_id);
        $filePath = $server->local_file_settings_path;

        if (Storage::disk('public')->exists($filePath)) {
            $fileContent = Storage::disk('public')->get($filePath);
            $settings = $this->parseIniString($fileContent);

            return compact('settings', 'apiServer');
        } else {
            abort(404, 'File not found.');
        }
    }

    protected function getApiServerData($serverHostId)
    {
        $url = "https://api.nitrado.net/services/{$serverHostId}/gameservers";
        return $this->getApiRequest($url, config('constants.nitrado.api_token'), [])->json();
    }

    protected function parseIniString($fileContent)
    {
        $data = [];
        $lines = explode("\n", $fileContent);

        foreach ($lines as $line) {
            if (strpos(trim($line), ';') === 0) continue;
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $data[trim($key)] = trim($value);
            }
        }

        return $data;
    }



}
