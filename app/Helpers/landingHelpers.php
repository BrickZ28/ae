<?php

use App\Models\Screenshot;

if (! function_exists('getRandomScreenshot')) {
    function getRandomScreenshot()
    {
        $image = Screenshot::inRandomOrder()->limit(4)->get();
        return $image;
    }
}
