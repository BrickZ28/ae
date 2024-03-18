<?php

return [

    'disks' => [
        'vultr' => [
            'driver' => 's3',
            'key' => env('VULTR_ACCESS_KEY'),
            'secret' => env('VULTR_SECRET_KEY'),
            'region' => env('VULTR_REGION'),
            'bucket' => env('VULTR_BUCKET'),
            'endpoint' => env('VULTR_ENDPOINT'),
        ],

        'do' => [
            'driver' => 's3',
            'key' => env('DO_ACCESS_KEY_ID'),
            'secret' => env('DO_SECRET_ACCESS_KEY'),
            'region' => env('DO_DEFAULT_REGION'),
            'bucket' => env('DO_BUCKET'),
            'folder' => env('DO_FOLDER'),
            'cdn_endpoint' => env('DO_CDN_ENDPOINT'),
            'url' => env('DO_URL'),
            'endpoint' => env('DO_ENDPOINT'),
            'use_path_style_endpoint' => env('DO_USE_PATH_STYLE_ENDPOINT', false),
            'bucket_endpoint' => true,
        ],
    ],

];
