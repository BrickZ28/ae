<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\DiscordService;
use Laravel\Socialite\Facades\Socialite;

class FetchDiscordUserMiddleware
{
    protected $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }
    public function handle($request, Closure $next)
    {
        $socialiteUser = Socialite::driver('discord')->stateless()->user();
        $accessToken = $socialiteUser->token;
        $roles = $this->discordService->fetchUserRoles($socialiteUser->id);
        $clientIp = $request->ip();

        // Store the necessary user information in the session
        $request->session()->put('socialiteUser', $socialiteUser);
        $request->session()->put('accessToken', $accessToken);
        $request->session()->put('roles', $roles);
        $request->session()->put('clientIp', $clientIp);

        return $next($request);
    }
}
