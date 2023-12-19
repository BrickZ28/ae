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
    public function redirect(\Illuminate\Http\Request $request)
    {
        $provider = 'discord';
        // redirect from social site
        if (request()->input('state')) {
            // already logged in
            // get user info from social site
            $user = Socialite::driver($provider)->stateless()->user();

            // check for existing user
            $existingUser = User::where('email', $user->getEmail())->first();

            if ($existingUser) {
                auth()->login($existingUser, true);

                return redirect()->to('/dashboard');
            }

            $newUser = $this->createUser($user, $request);
            auth()->login($newUser, true);
        }

        // request login from social site
        return redirect()->to('/dashboard');
    }


    function createUser($user, $request)
    {
        //        if ($user->markEmailAsVerified()) {
//            event(new Verified($user));
//        }


        return User::updateOrCreate([
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
