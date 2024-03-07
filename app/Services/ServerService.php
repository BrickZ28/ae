<?php

namespace App\Services;

use App\Models\Server;
use App\Traits\ApiRequests;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Storage;
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

    public function updateServer(Server $server, $request)
    {
        if ($request->style){
        $server->playstyle_id = $request->style;
        $server->save();
        }

        if (!$request->hasFile('file') && $request->style){
            return redirect()->route('servers.index')->with('success', 'Style added to server');
        }

        if ($request->hasFile('file')) {
            $files = $request->file('file'); // Adjusted to handle multiple files
            $combinedContent = '';

            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                if (strtolower($extension) != 'ini') {
                    return redirect()->route('servers.index')->with('success', 'Files combined and uploaded successfully');
                }

                // Combine content of all .ini files
                $combinedContent .= file_get_contents($file) . "\n";
            }

            $disk = 'public';
            $folder = 'servers/' . $server->serverhost_id . '/json';
            $filename = 'GameSettings.ini'; // Name of the combined file
            $path = $folder . '/' . $filename;

            // Check if combined content is not empty
            if (!empty($combinedContent)) {
                // Save combined content to a new or existing file
                Storage::disk($disk)->put($path, $combinedContent);

                // Update the server's local_file_settings_path
                $server->local_file_settings_path = $path;

                $server->save();

                return redirect()->route('servers.index')->with('success', 'Files combined and uploaded successfully');
            } else {
                return redirect()->route('servers.index')->with('error', 'Failed to combine files');
            }
        } else {
            return redirect()->route('servers.index')->with('error', 'No file present');
        }
    }

    public function fetchAndStoreServers()
    {
        $api_data = $this->getApiRequest("https://api.nitrado.net/services", config('constants.nitrado.api_token'), []);

        if ($api_data['status'] === 'success') {
            foreach ($api_data['data']['services'] as $service) {
                $server_info = $this->getApiRequest("https://api.nitrado.net/services/{$service['id']}/gameservers",
                    config('constants.nitrado.api_token', []));
                $game_human = $server_info['data']['gameserver']['game_human'];

                $game = Game::where('api_name', $game_human)->first();

                $server_data = [
                    'name' => $service['details']['name'],
                    'ip' => $service['details']['address'],
                    'serverhost_id' => $service['id'],
                    'comments' => $service['comment'],
                    'slots' => $service['details']['slots'],
                    'status' => $service['status'],
                    'start_date' => $service['start_date'],
                    'end_date' => $service['suspend_date'],
                    'crossplay' => (bool)$service['is_xcross'],
                    'game_id' => $game->id ?? null,
                ];

                if (Server::firstOrCreate($server_data)) {
                    Alert::success('servers_stored', 'Servers stored successfully');
                }
            }
        } else {
            Alert::error('error', 'Servers did not store successfully');
        }
    }


}
