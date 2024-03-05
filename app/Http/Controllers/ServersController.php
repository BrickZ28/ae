<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Server;
use App\Services\ApiService;
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
    public function index()
    {
        $servers = Server::getFromAPI();
        $filters = ['id', 'name', 'slots', 'renew by', 'status', 'game', 'actions'];
        return view('dashboard.server.index', compact('servers', 'filters'));
    }

    public function create()
    {
        return view('dashboard.server.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(['name' => 'required']);
        Server::firstOrCreate([
            'name' => $validatedData['name'],
            'ip' => $request->ip(),
        ]);
        Alert::success('Server Created', 'New server created successfully');
        return redirect()->route('dashboard.index');
    }

    public function show($id)
    {
        $server = Server::where('serverhost_id', $id)->firstOrFail();
        $apiServer = $this->getApiServerData($server->serverhost_id);
        $settings = $this->getServerSettingsFromFile($server->local_file_settings_path);
        if ($settings === null) {
            abort(404, 'File not found.');
        }
        return view('dashboard.server.show', compact('server', 'apiServer', 'settings'));
    }

    public function edit($id)
    {
        $server = Server::where('serverhost_id', $id)->first();
        return view('dashboard.server.edit', compact('server'));
    }

    public function update(Request $request, Server $server)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            if (strtolower($extension) != 'ini') {
                return redirect()->route('servers.index')->with('error', 'The file must be an .ini file.');
            }

            $disk = 'public';
            $folder = 'servers/' . $server->serverhost_id . '/json';
            $path = Storage::disk($disk)->putFileAs($folder, $file, $file->getClientOriginalName());

            if ($path) {
                $server->local_file_settings_path = $path;
                $server->save();
                return redirect()->route('servers.index')->with('success', 'File uploaded successfully');
            } else {
                return redirect()->route('servers.index')->with('error', 'File failed to upload');
            }
        } else {
            return redirect()->route('servers.index')->with('error', 'No file present');
        }
    }

    public function destroy(Server $server)
    {
        // Implement server deletion logic here, if needed.
    }

    protected function getApiServerData($serverHostId)
    {
        $url = "https://api.nitrado.net/services/{$serverHostId}/gameservers";
        return $this->getApiRequest($url, config('constants.nitrado.api_token'), [])->json();
    }

    protected function getServerSettingsFromFile($filePath)
    {
        if (!Storage::exists($filePath)) {
            return null;
        }
        $fileContent = Storage::get($filePath);
        return $this->parseIniString($fileContent);
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


