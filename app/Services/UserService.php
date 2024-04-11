<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;

class UserService
{
    protected $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }

    public function userIsMember($socialiteUser)
{
    $user = User::whereEmail($socialiteUser->email)->first();

    if ($user->hasAnyRole(['Member'])) {
        return $user;
    } else {
        return false;
    }
}

    public function updateUser($user, $socialiteUser, $clientIp, $accessToken, $roles)
    {
        // Update or set user authentication-related attributes
        $user->fill([
            'discord_id' => $socialiteUser->id,
            'username' => $socialiteUser->user['username'],
            'discriminator' => $socialiteUser->user['discriminator'],
            'verified' => $socialiteUser->user['verified'],
            'mfa_enabled' => $socialiteUser->user['mfa_enabled'],
            'premium_type' => $socialiteUser->user['premium_type'],
            'last_login_at' => Carbon::now(),
            'last_login_ip' => $clientIp,
            'discord_access_token' => $accessToken,
            'ae_credits' => $user->exists ? $user->ae_credits : 500, // Preserve credits if user exists, else set default
        ])->save();

        // Now, handle the UserProfile data
        UserProfile::updateOrCreate(
            ['user_id' => $user->id], // Unique identifier for the profile
            [
                'global_name' => $socialiteUser->user['global_name'],
                'profile_photo_path' => $socialiteUser->avatar,
                'avatar' => $socialiteUser->user['avatar'],
                'banner' => $socialiteUser->user['banner'],
                'banner_color' => $socialiteUser->user['banner_color'],
                'accent_color' => $socialiteUser->user['accent_color'],
                'locale' => $socialiteUser->user['locale'],
                'public_flags' => $socialiteUser->user['public_flags'],
                // Any other public profile-related fields
            ]
        );

//        $this->discordService->assignDiscordRole($socialiteUser->id);


        // Sync roles for the user
        $this->discordService->syncUserRoles($socialiteUser->id, $roles);

        return $user;
    }

}
