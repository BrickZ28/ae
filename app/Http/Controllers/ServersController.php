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
        $this->serverService->createServer($request->all());

        return view('dashboard.index');
    }


	public function show($id)
	{
        $data = $this->serverService->getServerData($id);
        return view('dashboard.server.show', $data);
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
        return $this->serverService->updateServer($server, $request);
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


