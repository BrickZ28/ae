<?php

use App\Models\Screenshot;
use App\Models\Server;
use App\Traits\ApiRequests;

if (! function_exists('getRandomScreenshot')) {
    function getRandomScreenshot()
    {
        $image = Screenshot::inRandomOrder()->limit(4)->get();
        return $image;
    }

}

