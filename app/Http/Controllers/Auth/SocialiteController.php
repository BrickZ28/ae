<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function authenticate()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function redirect(Request $request)
    {
        $provider = 'discord';

// Redirect from social site
        if (request()->input('state')) {
            // Get user info from social site
            $user = Socialite::driver($provider)->stateless()->user();
            $accessToken = $user->token;
            // Check for existing user
            $existingUser = User::where('email', $user->getEmail())->first();

            $guildsResponse = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}"
            ])->get('https://discord.com/api/users/@me/guilds');

            $guilds = json_decode($guildsResponse->body());



            foreach ($guilds as $guild) {
                dd($guild);
                // Skip guilds where the bot isn't a member
                if ($guild->id !== '499839691370135552') {

                }

                $memberResponse = Http::withHeaders([
                    'Authorization' => 'Bot ' . ''
                ])->get("https://discord.com/api/guilds/{$guild->id}/members/{$user->discord_id}");

                $member = json_decode($memberResponse->body());

                dd($member->roles);

                foreach ($member->roles as $roleId) {
                    // Sync this role with your database
                }
            }

            if ($existingUser) {
                auth()->login($existingUser, true);
                $existingUser->update([
                    'discord_access_token' => $accessToken
                ]);
                return redirect()->to('/dashboard');
            }

            $newUser = $this->createUser($user, $request);
            $newUser->update([
                'discord_access_token' => $accessToken
            ]);
            auth()->login($newUser, true);
        }

    }

    function createUser($user, $request)
    {
        return User::updateOrCreate([
            'discord_id' => $user->id,
            'username' => $user->user['username'],
            'global_name' => $user->user['global_name'],
            'discriminator' => $user->user['discriminator'],
            'email' => $user->email,
            'profile_photo_path' => $user->avatar,
            'avatar' => $user->user['avatar'],
            'verified' => $user->user['verified'],
            'banner' => $user->user['banner'],
            'banner_color' => $user->user['banner_color'],
            'accent_color' => $user->user['accent_color'],
            'locale' => $user->user['locale'],
            'mfa_enabled' => $user->user['mfa_enabled'],
            'premium_type' => $user->user['premium_type'],
            'public_flags' => $user->user['public_flags'],
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    protected function createPersonalAccessToken($user)
    {
        $userInstance = User::updateOrCreate([
            'discord_id' => $user->id,
            // Add other user data as needed
        ]);

        $tokenName = 'Discord Access Token';
        $sanctumToken = $userInstance->createToken($tokenName, ['*']);

        return $sanctumToken;
    }
}
