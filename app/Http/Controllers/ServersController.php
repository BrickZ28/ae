<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Server;
use App\Services\ApiService;
use App\Traits\ApiRequests;
use Illuminate\Http\Request;
use App\Helpers\StringHelper;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;


class ServersController extends Controller
{
    use ApiRequests;
	public function index()
	{
        return view('dashboard.server.index')->with([
            'servers' => Server::getFromAPI(),
            'filters' => ['id', 'name', 'slots', 'renew by', 'status', 'game', 'actions']
        ]);
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
        $server = $this->getApiRequest(null,null,"services/{$id}/gameservers");
        $settings = $server['data']['gameserver'];
        $mating_interval_multiplier = StringHelper::extractValue
        ($server['data']['gameserver']['settings']['gameini']['MatingIntervalMultiplier']);
        $hatch_speed_multiplier = StringHelper::extractValue($server['data']['gameserver']['settings']['gameini']['EggHatchSpeedMultiplier']);
        $baby_cuddle_multiplier = StringHelper::extractValue($server['data']['gameserver']['settings']['gameini']['BabyCuddleIntervalMultiplier']);
        $baby_imprint_multiplier = StringHelper::extractValue($server['data']['gameserver']['settings']['gameini']['BabyImprintAmountMultiplier']);

        return view('dashboard.server.show',
            compact('settings',
                'mating_interval_multiplier',
            'hatch_speed_multiplier',
            'baby_cuddle_multiplier',
            'baby_imprint_multiplier'));
    }


	public function edit(Server $server)
	{

        return view('dashboard.server.edit')->with([
            'server' => $server,
        ]);
	}

	public function update(Request $request, Server $server)
	{

        $phrases = explode(", ", $request->settings);
        $route = Route::current(); // Illuminate\Routing\Route
        $name = Route::currentRouteName(); // string
        $action = Route::currentRouteAction(); // string
        dd(53, $route, $name, $action);

//        dd($request, $phrases, 68);
	}

	public function destroy(Server $server)
	{
	}
    public function getNitradoServers()
    {
        $api_data = $this->getApiRequest(null, [], 'services');

        if ($api_data['status'] === 'success') {
            foreach ($api_data['data']['services'] as $service) {
                $server_info = $this->getApiRequest(null, null, "services/{$service['id']}/gameservers");
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
                    'game_id' => $game->id,
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

    private function extractMultiplier($key, $path)
    {
        $parts = explode("=", $path[$key]);
        return $parts[1];
    }
}


