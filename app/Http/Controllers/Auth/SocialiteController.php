<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Gate;
use App\Models\Item;
use App\Models\User;
use App\Services\DiscordService;
use App\Services\GateService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    protected $discordService;
    protected $userService;
    protected $gateService;

    public function __construct(DiscordService $discordService, UserService $userService, GateService $gateService)
    {
        $this->discordService = $discordService;
        $this->userService = $userService;
        $this->gateService = $gateService;
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

        if ($request->game === 'asepve' || $request->game === 'asepvp') {
            $this->gateService->issueGate('starter', $socialiteUser, $request->game);
        }

        $user = $this->userService->updateUser(null, $socialiteUser, $clientIp, $accessToken, $roles);


        return redirect()->route('logout', ['fromRegistration' => true]);

    }


    public function logout(Request $request)
    {
        $fromRegistration = $request->get('fromRegistration', false);

        Auth::logout();

        // If the logout was called from the registration process, redirect them to the login route
        if ($fromRegistration) {
            return redirect()->route('discord.register');
        }

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
