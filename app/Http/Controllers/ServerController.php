<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class ServerController extends Controller
{

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }


	public function index()
	{
        return view('dashboard.server.index')->with([
            'servers' => Server::all(),
            'filters' => ['serverhost_id', 'name', 'slots', 'end_date', 'status', ]
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

        if(Server::create([
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
	}

	public function update(Request $request, Server $server)
	{
	}

	public function destroy(Server $server)
	{
	}


    public function fetchApiData()
    {
        // Call the fetchData method from the ApiService
        $data = $this->apiService->fetchData('https://api.example.com/data');

        // Process the data or return it as needed
        return response()->json($data);
    }

    public function getNitradoServers()
    {
        $response = Http::withToken(config('constants.nitrado.api_token'))
            ->accept('application/json')
            ->get('https://api.nitrado.net/services');

        $data = $response->json();

        if ($data['status'] === 'success') {
            foreach ($data['data']['services'] as $service) {


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
                ]);
            }
        } else {
            // Handle error status
            return  null;
        }
    }
}
