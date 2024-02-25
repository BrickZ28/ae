<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class UserService {
    protected $discordService;

    public function __construct(DiscordService $discordService) {
        $this->discordService = $discordService;
    }

    public function findOrCreateUser($socialiteUser, $accessToken, $roles, $clientIp) {
        // Attempt to find the user by email or create a new one
        $user = User::firstOrNew(['email' => $socialiteUser->email]);

        // Update or set user attributes
        $user->fill([
            'discord_id' => $socialiteUser->id,
            'username' => $socialiteUser->user['username'],
            'global_name' => $socialiteUser->user['global_name'],
            'discriminator' => $socialiteUser->user['discriminator'],
            'profile_photo_path' => $socialiteUser->avatar,
            'avatar' => $socialiteUser->user['avatar'],
            'verified' => $socialiteUser->user['verified'],
            'banner' => $socialiteUser->user['banner'],
            'banner_color' => $socialiteUser->user['banner_color'],
            'accent_color' => $socialiteUser->user['accent_color'],
            'locale' => $socialiteUser->user['locale'],
            'mfa_enabled' => $socialiteUser->user['mfa_enabled'],
            'premium_type' => $socialiteUser->user['premium_type'],
            'public_flags' => $socialiteUser->user['public_flags'],
            'last_login_at' => Carbon::now(),
            'last_login_ip' => $clientIp,
            'discord_access_token' => $accessToken,
            'ae_credits' => $user->exists ? $user->ae_credits : 500, // Preserve credits if user exists, else set default
        ])->save();

        // Sync roles for the user
        $this->discordService->syncUserRoles($socialiteUser->id, $roles);

        return $user;
    }

}
