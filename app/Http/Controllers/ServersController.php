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

//        $server = $this->getApiRequest(null,null,"services/{$id}/gameservers");
//        $settings = $server['data']['gameserver'];


        $server = Server::where('serverhost_id', $id)->first();
        $filePath = $server->local_file_settings_path;

        if (Storage::disk('public')->exists($filePath)) {

            if (file_exists($filePath)) {
                // Parse the INI file into an associative array
                $data = parse_ini_file($filePath, true, INI_SCANNER_TYPED);

                // Use $data as needed
                // For example, print the entire array or a specific value
                echo '<pre>';
                print_r($data);
                echo '</pre>';

                // To access a specific value, specify the section and the key
                // Example: echo $data['SectionName']['KeyName'];
            } else {
                echo 'File not found.';
            }


        $mating_interval_multiplier = StringHelper::extractValue
        ($server['data']['gameserver']['settings']['gameini']['MatingIntervalMultiplier']);
        $hatch_speed_multiplier = StringHelper::extractValue
        ($server['data']['gameserver']['settings']['gameini']['EggHatchSpeedMultiplier']);
        $baby_cuddle_multiplier = StringHelper::extractValue
        ($server['data']['gameserver']['settings']['gameini']['BabyCuddleIntervalMultiplier']);
        $baby_imprint_multiplier = StringHelper::extractValue
        ($server['data']['gameserver']['settings']['gameini']['BabyImprintAmountMultiplier']);

        return view('dashboard.server.show',
            compact('settings',
                'mating_interval_multiplier',
            'hatch_speed_multiplier',
            'baby_cuddle_multiplier',
            'baby_imprint_multiplier'));
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
            // Define the disk where files should be stored (e.g., 'local', 'public', 's3')
            $disk = 'public';

            // Define the folder path, incorporating the server's identifier for organization
            $folder = 'servers/' . $server->serverhost_id . '/json';


            // Retrieve the uploaded file from the request
            $file = $request->file('file');

            // Attempt to upload the file using the trait's method
            $path = $this->uploadFile($disk, $folder, $file);


            if ($path) {
                // Optionally, save the path in your server model or perform other actions
                 $server->local_file_settings_path = $path;
                 $server->save();

                // Respond with success
                return redirect()->route('servers.index')->with('success','File uploaded successfully' );
            } else {
                // Handle upload failure
                return redirect()->route('servers.index')->with('error','File failed to upload' );
            }
        } else {
            // No file was uploaded
            return redirect()->route('servers.index')->with('error','No File present' );
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

    public function readJsonFile()
    {
        // Specify the path to your JSON file within the storage/app/public directory
        $filePath = 'public/example.json';

        // Check if the file exists
        if (Storage::exists($filePath)) {
            // Read the file content
            $jsonContent = Storage::get($filePath);

            // Decode the JSON content into a PHP array
            $dataArray = json_decode($jsonContent, true);

            // Alternatively, to get an object instead of an array, you can do:
            // $dataObject = json_decode($jsonContent);

            // Use $dataArray or $dataObject as needed
            // For example, return it as a response or pass it to a view
            return response()->json($dataArray);
        } else {
            // Handle the case where the file does not exist
            return response()->json(['error' => 'File not found.'], 404);
        }
    }


}


