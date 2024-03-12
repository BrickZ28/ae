<?php

use App\Models\Screenshot;
use App\Models\Specials;

if (! function_exists('getRandomScreenshot')) {
    function getRandomScreenshot()
    {
        $image = Screenshot::inRandomOrder()->limit(4)->get();

        return $image;
    }
}

if (! function_exists('getSpecials')) {
    function getSpecials()
    {
        return Specials::where('active', 1)->get();
    }

}

if (! function_exists('getRandomImage')) {
    function getRandomImage()
    {
        // Path to the directory containing images
        $directory = public_path('assets/media/illustrations/dozzy-1');

        // Get all image files from the directory
        $imageFiles = glob($directory.'/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        // If there are no image files, return null
        if (empty($imageFiles)) {
            return null;
        }

        // Shuffle the array of image files to randomize their order
        shuffle($imageFiles);

        // Select the first image from the shuffled array
        $randomImage = $imageFiles[0];

        // Return the URL to the randomly selected image
        return asset(str_replace(public_path(), '', $randomImage));
    }
}
