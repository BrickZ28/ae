<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Playstyle;
use App\Models\Server;
use App\Services\ServerService;
use App\Traits\ApiRequests;
use App\Traits\FileTrait;
use Illuminate\Http\Request;

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
        $server = Server::where('id', $id)->with('playstyle')->first();
        $playstyles = Playstyle::all();
        $games = Game::all();

        return view('dashboard.server.edit', compact('server', 'playstyles', 'games'));
    }

    public function update(Request $request, Server $server)
    {
        return $this->serverService->updateServer($server, $request);
    }

    public function destroy(Server $server)
    {
        $server->delete();

        return redirect()->route('dashboard.index')->with('success', 'Server deleted successfully');
    }

    public function getServers()
    {
        $this->serverService->fetchAndStoreServers();

        return view('dashboard.index');
    }
}
