<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\DiscordService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use App\Traits\ApiRequests;

class SocialiteController extends Controller
{
    protected $discordService;
    protected $userService;

    public function __construct(DiscordService $discordService, UserService $userService) {
        $this->discordService = $discordService;
        $this->userService = $userService;
    }

    public function authenticate() {
        return Socialite::driver('discord')->scopes(['identify', 'guilds'])->redirect();
    }

    public function handleOAuthCallback(Request $request) {
        $socialiteUser = Socialite::driver('discord')->stateless()->user();
        $accessToken = $socialiteUser->token;
        $roles = $this->discordService->fetchUserRoles($socialiteUser->id);
        $clientIp = $request->ip(); // Get client IP address

        $user = $this->userService->findOrCreateUser($socialiteUser, $accessToken, $roles, $clientIp);

        Auth::login($user, true);
        return redirect()->to('/dashboard');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
