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
            'ip' => $request->ip,
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

        return view('dashboard.server.show', compact('settings', 'apiServer'));
    }

    protected function getApiServerData($serverHostId)
    {
        $url = "https://api.nitrado.net/services/{$serverHostId}/gameservers";
        return $this->getApiRequest($url, config('constants.nitrado.api_token'), [])->json();
    }

    protected function getServerSettingsFromFile($filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            $fileContent = Storage::disk('public')->get($filePath);
            return $this->parseIniString($fileContent);
        }

        return null;
    }

    public function edit($id)
    {
        $server = Server::where('serverhost_id', $id)->firstOrFail();
        return view('dashboard.server.edit', compact('server'));
    }

    public function update(Request $request, Server $server)
    {
        if (!$request->hasFile('file')) {
            return back()->with('error', 'No file present');
        }

        $file = $request->file('file');
        $validationResult = $this->validateAndUploadFile($file, $server);

        return $validationResult ?: back()->with('success', 'File uploaded successfully');
    }

    protected function validateAndUploadFile($file, $server)
    {
        if ($file->getClientOriginalExtension() != 'ini') {
            return back()->with('error', 'The file must be an .ini file.');
        }

        $folder = 'servers/' . $server->serverhost_id . '/json';
        $path = $this->uploadOrAppendFile($file, $server, $folder);

        if (!$path) {
            return back()->with('error', 'File failed to upload');
        }

        $server->update(['local_file_settings_path' => $path]);
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


