<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Server;
use App\Services\ApiService;
use App\Services\ServerService;
use App\Traits\ApiRequests;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use App\Helpers\StringHelper;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;


class ServersController extends Controller
{
    use ApiRequests, FileTrait;

    protected $serverService;

    public function __construct(ServerService $serverService)
    {
        $this->serverService = $serverService;
    }
	public function index()
	{
        $data = $this->serverService->getServersWithFilters();
        return view('dashboard.server.index', $data);

    }

	public function create()
	{
        return view('dashboard.server.create');
	}

	public function store(Request $request)
	{
        $request->validate([
            'name' => 'required',
        ]);

        if(Server::firstOrCreate ([
            'name' => $request->name,
            'ip' => $request->ip,
        ])) {
            Alert::success('Server Created', 'New server created successfully');
        }

        return view('dashboard.index');
    }

    public function dj()
    {
        $server = $this->getApiRequest(null,null,"services/2877144/gameservers");
        $settings = $server;
        dd($settings);
    }

	public function show($id)
	{


        $server = Server::where('serverhost_id', $id)->firstOrFail();
        $api_server = $this->getApiRequest("https://api.nitrado.net/services/{$server->serverhost_id}/gameservers",
            config('constants.nitrado.api_token'),
            [])->json();
        $filePath = $server->local_file_settings_path;

        if (Storage::disk('public')->exists($filePath)) {
            $fileContent = Storage::disk('public')->get($filePath);
            $settings = $this->parseIniString($fileContent);

            // Pass the parsed data to your Blade view
            return view('dashboard.server.show', compact('settings', 'api_server'));
        } else {
            // Alternatively, handle the file not existing as needed
            abort(404, 'File not found.');
        }
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


	public function edit($id)
	{
        $server = Server::where('serverhost_id', $id)->first();


        return view('dashboard.server.edit')->with([
            'server' => $server,
        ]);
	}

    public function update(Request $request, Server $server)
    {
        // Check if a file was uploaded with the request
        if ($request->hasFile('file')) {
            // Validate the file is an .ini file
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            if (strtolower($extension) != 'ini') {
                return redirect()->route('servers.index')->with('error', 'The file must be an .ini file.');
            }

            // Define the disk where files should be stored
            $disk = 'public';
            // Define the folder path, incorporating the server's identifier for organization
            $folder = 'servers/' . $server->serverhost_id . '/json';

            // Check if the filename starts with 'GameUserSettings'
            if (strpos($file->getClientOriginalName(), 'GameUserSettings') === 0) {
                // Upload or replace the current file
                $path = $this->uploadFile($disk, $folder, $file);
            } else {
                // For files not starting with 'GameUserSettings', append to the existing GameUserSettings.ini if it exists
                if (empty($server->local_file_settings_path)) {
                    return redirect()->route('servers.index')->with('error', 'Please upload the GameUserSettings.ini file first.');
                } else {
                    // Ensure the GameUserSettings.ini file exists
                    $existingFilePath = $server->local_file_settings_path;
                    if (!Storage::disk($disk)->exists($existingFilePath)) {
                        return redirect()->route('servers.index')->with('error', 'GameUserSettings.ini file not found.');
                    }

                    // Append the content of the uploaded file to the GameUserSettings.ini file
                    $existingContent = Storage::disk($disk)->get($existingFilePath);
                    $newContent = file_get_contents($file);
                    Storage::disk($disk)->put($existingFilePath, $existingContent . "\n" . $newContent);
                    $path = $existingFilePath; // Since we're appending, the path remains the same
                }
            }

            if ($path) {
                // Update the server's path with the new or appended file's path
                $server->local_file_settings_path = $path;
                $server->save();

                // Respond with success
                return redirect()->route('servers.index')->with('success', 'File uploaded successfully');
            } else {
                // Handle upload or append failure
                return redirect()->route('servers.index')->with('error', 'File failed to upload');
            }
        } else {
            // No file was uploaded
            return redirect()->route('servers.index')->with('error', 'No file present');
        }
    }


    public function destroy(Server $server)
	{
	}

    public function getServers()
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

        return view('dashboard.index');
    }



}


