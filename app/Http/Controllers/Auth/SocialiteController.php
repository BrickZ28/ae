<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        //middleware this stuff since its used on all login/register request
        $socialiteUser = $request->session()->get('socialiteUser');
        $accessToken = $request->session()->get('accessToken');
        $roles = $request->session()->get('roles');
        $clientIp = $request->session()->get('clientIp');


        //Next we need to check if the user is a member or not
        //if a user we will need to sync info to the database
        //if not a user we will need to redirect to the option modal

//        $user = $this->userService->findOrCreateUser($socialiteUser, $accessToken, $roles, $clientIp);
        $user = $this->userService->userIsMember($socialiteUser);



        if ($user) {
            $this->userService->updateUser($user, $socialiteUser, $clientIp, $accessToken, $roles);
            Auth::login($user, true);
            return redirect(route('dashboard.index'));
        } else {
            return redirect()->to('/dashboard/registration/play-options');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }
}
