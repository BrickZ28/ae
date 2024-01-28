<?php

namespace App\Http\Controllers;

use App\Events\DiscordTestEvent;
use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Notifications\Notifiable;
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

        dd($request);
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
}