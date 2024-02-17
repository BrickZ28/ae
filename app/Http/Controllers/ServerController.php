<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

class ServerController extends Controller
{
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

	public function show(Server $server)
	{

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
        $data = $this->apiService->fetchJsonDataArray(config('constants.nitrado.api_token'),'https://api.nitrado.net/services');

        if ($data['status'] === 'success') {
            foreach ($data['data']['services'] as $service) {
                if (
                Server::create([
                    'name' => $service['details']['name'],
                    'ip' => $service['details']['address'],
                    'serverhost_id' => $service['id'] ,
                    'comments' => $service['comment'],
                    'slots' => $service['details']['slots'],
                    'status' => $service['status'],
                    'start_date' => $service['start_date'],
                    'end_date' => $service['suspend_date'],
                    'crossplay' => (bool)$service['is_xcross'],
                    'game' => $service['details']['game'],
                ])) {
                    Alert::success('Servers stored', 'Servers stored successfully');
                }
            }
        } else {
            Alert::error('Error', 'Servers did not store successfully');
        }
        return view('dashboard.index');
    }
}
