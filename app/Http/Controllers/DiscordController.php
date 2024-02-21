<?php

namespace App\Http\Controllers;

use App\Events\DiscordTestEvent;
use App\Models\User;
use App\Notifications\TestNotification;
use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordInteractionServiceContract;
use Illuminate\Http\Request;

class DiscordController extends Controller
{
    use  Notifiable;
    private $interactionService;


    public function __construct(DiscordInteractionServiceContract $interactionService)
    {
        $this->interactionService = $interactionService;
    }

    public function handleDiscordInteraction(Request $request)
    {

        $response = $this->interactionService->handleInteractionRequest($request);

        return response()->json($response->toArray(), $response->getStatus());
    }

    public function fromDiscord(Request $request)
    {
        $currentUser = auth()->user()->id;

        $user = User::where('discord_id', $request->user)->first();

        if($currentUser !== $user->id){
            dd('DENIED');
        }

        dd($user);
        // Access headers
        $authorizationHeader = $request->header('Authorization');
        $customHeader = $request->header('Custom-Header');

        $headers = getallheaders();
        $userID = $headers['User-ID'];
        $userName = $headers['User-Name'];
        $userDiscriminator = $headers['User-Discriminator'];

// Process the information as needed
        echo "Received user information:\n";
        echo "User ID: $userID\n";
        echo "Username: $userName\n";
        echo "Discriminator: $userDiscriminator\n";

        // Add your logic here to process the request
        dd($request->headers->all());

        return response()->json(['status' => 'success']);

    }

    public function index()
    {

        $user = User::where('username', 'brick8083')->first();


        $user->notify(new TestNotification());
    }

    public function receiveInfo(Request $request)
    {
        // Retrieve data sent from the Discord bot
        $userId = $request->input('user_id');
        $userName = $request->input('user_name');
        $userDiscriminator = $request->input('user_discriminator');

        // Process the information as needed
        $response = [
            'status' => 'success',
            'message' => 'Received user information',
            'user_id' => $userId,
            'user_name' => $userName,
            'user_discriminator' => $userDiscriminator,
        ];

        return response()->json($response);
    }

    public function getUserInfo(Request $request)
    {
        // Access token obtained through OAuth2
        $accessToken = $request->session()->get('tH4FN2cVBnKiexW1QOWQBdU63Pj8oPTPK5nmC1r7OUgOuYCWREDEhGQHXYn8');

        // Discord API endpoint for fetching user information
        $endpoint = "https://discord.com/api/users/@me";

        // Make a GET request to Discord API with the access token
        $response = Http::withToken($accessToken)->get($endpoint);

        // Check if the request was successful
        if ($response->successful()) {
            // Decode the JSON response
            $userData = $response->json();

            // Extract user information
            $userId = $userData['id'];
            $username = $userData['username'];
            $avatarUrl = "https://cdn.discordapp.com/avatars/{$userId}/{$userData['avatar']}.png";

            // Return user information
            return view('discord.user_info', [
                'userId' => $userId,
                'username' => $username,
                'avatarUrl' => $avatarUrl,
                // Add more user information here as needed
            ]);
        } else {
            // Handle the error response
            return "Failed to fetch user data from Discord API.";
        }
    }
}
