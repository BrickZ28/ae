<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\DiscordService;
use App\Traits\ApiRequests;

class DiscordController extends Controller
{
    protected $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }

    public function syncRolesAndRedirect()
    {
        $this->discordService->syncDiscordRoles();
        return redirect()->route('dashboard.index')->with('success', 'Roles added successfully');
    }

}
