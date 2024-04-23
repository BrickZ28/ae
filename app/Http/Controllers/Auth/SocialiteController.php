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
