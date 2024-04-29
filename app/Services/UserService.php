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

    public function userIsMember($socialiteUser, $roles)
    {
        $user = User::whereEmail($socialiteUser->email)->first();

        if ($user) {
            $memberRoleId = Role::where('role_name', 'Member')->first()->role_id;

            foreach ($roles as $role) {
                if ($role === $memberRoleId) {
                    return $user;
                }
            }
        }

        return false;
    }

    public function updateUser($user, $socialiteUser, $clientIp, $accessToken, $roles)
    {
        $user = $this->updateUserAuthentication($user, $socialiteUser, $clientIp, $accessToken);
        $this->updateUserProfile($user, $socialiteUser);
        $this->syncUserRoles($socialiteUser, $roles);

        return $user;
    }

    private function updateUserAuthentication($user, $socialiteUser, $clientIp, $accessToken)
    {
        if (!$user) {
            $user = new User;
        }

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
            'ae_credits' => $user->exists ? $user->ae_credits : 500,
        ])->save();

        return $user;
    }

    private function updateUserProfile($user, $socialiteUser)
    {
        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'global_name' => $socialiteUser->user['global_name'],
                'profile_photo_path' => $socialiteUser->avatar,
                'avatar' => $socialiteUser->user['avatar'],
                'banner' => $socialiteUser->user['banner'],
                'banner_color' => $socialiteUser->user['banner_color'],
                'accent_color' => $socialiteUser->user['accent_color'],
                'locale' => $socialiteUser->user['locale'],
                'public_flags' => $socialiteUser->user['public_flags'],
            ]
        );
    }

    private function syncUserRoles( $socialiteUser, $roles)
    {

        $roleId = Role::where('role_name', 'Member')->first()->role_id;
        $this->discordService->assignDiscordRole($socialiteUser->id, $roleId);
        $this->discordService->syncUserRoles($socialiteUser->id, $roles);
    }

    public function updateStartKit($user, $game){
        if ($game === 'asepve'){
            $user->update(['asepve_start_kit' => true]);
        } elseif ($game === 'asepvp'){
            $user->update(['asepvp_start_kit' => true]);
        } elseif ($game === 'asapvp'){
            $user->update(['asapvp_start_kit' => true]);
        } elseif ($game === 'asapve'){
            $user->update(['asapve_start_kit' => true]);
        }
    }
}
