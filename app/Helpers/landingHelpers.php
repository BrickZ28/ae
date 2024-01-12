<?php

use App\Models\Screenshot;

if (! function_exists('getRandomScreenshot')) {
    function getRandomScreenshot()
    {
        $image = Screenshot::inRandomOrder()->first();

        return $image->path;
    }
}
