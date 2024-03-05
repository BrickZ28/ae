<?php

namespace App\Services;

use App\Models\Server;
use App\Traits\ApiRequests;
use App\Traits\FileTrait;
use RealRashid\SweetAlert\Facades\Alert;

class ServerService
{
    use ApiRequests, FileTrait;

    public function getServersWithFilters()
    {
        // Retrieve servers from the API.
        $servers = Server::getFromAPI();

        // Define the filters.
        $filters = [
            'id',
            'name',
            'slots',
            'renew by',
            'status',
            'game',
            'actions',
        ];

        return compact('servers', 'filters');
    }

}
