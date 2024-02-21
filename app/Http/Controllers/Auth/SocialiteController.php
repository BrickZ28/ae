<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Carbon;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    public function authenticate()
    {
        return Socialite::driver('discord')->redirect();
    }
//    public function redirect(\Illuminate\Http\Request $request)
//    {
//        $provider = 'discord';
//        // redirect from social site
//        if (request()->input('state')) {
//            // already logged in
//            // get user info from social site
//            $user = Socialite::driver($provider)->stateless()->user();
//            $accessToken = $user->token;
//
//
//
//            // check for existing user
//            $existingUser = User::where('email', $user->getEmail())->first();
//
//            if ($existingUser) {
//                auth()->login($existingUser, true);
//
//                return redirect()->to('/dashboard');
//            }
//
//            $newUser = $this->createUser($user, $request);
//            auth()->login($newUser, true);
//        }
//
//        // request login from social site
//        return redirect()->to('/dashboard');
//    }

    public function redirect(\Illuminate\Http\Request $request)
    {
        $provider = 'discord';

        // Check if the request contains the authorization code
        if ($request->input('code')) {
            // Get user info from social site
            $user = Socialite::driver($provider)->stateless()->user();

            // Access the access token
            $accessToken = $user->token;

            // Create a personal access token
            $sanctumToken = $this->createPersonalAccessToken($user);

            // Redirect to your desired route
            return redirect()->to('/dashboard');
        }

        // Redirect to a default route if the code is not present
        return redirect()->to('/login');
    }

    protected function createPersonalAccessToken($user)
    {
        // Retrieve the user instance
        $userInstance = User::updateOrCreate([
            'discord_id' => $user->id,
            // Add other user data as needed
        ]);

        // Create a personal access token for the user
        $tokenName = 'Discord Access Token';
        $sanctumToken = $userInstance->createToken($tokenName, ['*']);

        // Access the access token and token ID
        $accessToken = $sanctumToken->plainTextToken;
        $tokenId = $sanctumToken->token->id;

        // Optionally, you can store the access token details in your database
        // Insert the token ID and access token into your personal_access_tokens table
        // Here you would typically save this data to your database if needed

        return $sanctumToken;
    }


    function createUser($user, $request)
    {
        //        if ($user->markEmailAsVerified()) {
//            event(new Verified($user));
//        }


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
}
