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

    public function fromDiscord()
    {
        return 'Worked';
    }

    public function index()
    {

        $user = User::where('username', 'brick8083')->first();


        $user->notify(new TestNotification());
    }
}
