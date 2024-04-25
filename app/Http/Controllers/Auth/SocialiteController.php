<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Gate;
use App\Models\Item;
use App\Models\User;
use App\Services\DiscordService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    protected $discordService;
    protected $userService;

    public function __construct(DiscordService $discordService, UserService $userService)
    {
        $this->discordService = $discordService;
        $this->userService = $userService;
    }

    public function authenticate()
    {
        return Socialite::driver('discord')->scopes(['identify', 'guilds'])->redirect();
    }

    public function processUserAuthRequest(Request $request)
    {
        list($socialiteUser, $accessToken, $roles, $clientIp) = $this->getSessionData($request);

        $user = $this->userService->userIsMember($socialiteUser, $roles);
        //if user is a member, update user and redirect to dashboard
        if ($user) {
            $this->userService->updateUser($user, $socialiteUser, $clientIp, $accessToken, $roles);
            return $this->loginAndRedirect($user, 'dashboard.index');
        }

        return redirect(route('dashboard.play-options'));
    }

    public function processUserRegistration(Request $request)
    {
        [$socialiteUser, $accessToken, $roles, $clientIp] = $this->getSessionData($request);

        $this->discordService->newUserDiscordSetup($request, $socialiteUser);
        $this->discordService->syncDiscordRoles($request, $socialiteUser);

        if ($request->game === 'asepve' || $request->game === 'asapvp') {

            // Get the ID of the starter kit
            $starterKitId = Item::where('name', 'Starter Kit')->first()->id;

// Query the gates table for gates that have a starter kit
            $gatesWithStarterKit = Gate::whereHas('items', function ($query) use ($starterKitId) {
                $query->where('item_id', $starterKitId);
            })->get();

// From the list of gates with a starter kit, find the first gate that isn't assigned
            $gate = $gatesWithStarterKit->first(function ($gate) {
                return $gate->player == null;
            });
            $discordId = $socialiteUser->id; // Get the Discord ID

// Find the user in your users table that matches the Discord ID
            $user = User::where('discord_id', $discordId)->first();

            if ($user && $gate) {
                // If the user exists and the gate is available and has a starter kit
                $gate->update(['player_id' => $user->id]);

                $message = "Your gate ID is {$gate->gate_id} and the pin is {$gate->pin}.";
                $this->discordService->sendMessage($discordId, $message);
            } else {
                dd('No gates available or user not found');
            }
        }

        $user = $this->userService->updateUser(null, $socialiteUser, $clientIp, $accessToken, $roles);
        return $this->loginAndRedirect($user, 'dashboard.index');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }

    private function getSessionData(Request $request)
    {
        $socialiteUser = $request->session()->get('socialiteUser');
        $accessToken = $request->session()->get('accessToken');
        $roles = $request->session()->get('roles');
        $clientIp = $request->session()->get('clientIp');

        return [$socialiteUser, $accessToken, $roles, $clientIp];
    }

    private function loginAndRedirect($user, $route)
    {
        Auth::login($user, true);
        return redirect(route($route));
    }
}
