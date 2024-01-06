<?php

use App\Models\Screenshot;

if (! function_exists('getRandomScreenshot')) {
    function getRandomScreenshot(): Screenshot
    {
        return Screenshot::inRandomOrder()->first();
    }
}
