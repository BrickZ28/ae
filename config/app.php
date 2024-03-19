<?php

use Illuminate\Support\Facades\Facade;

return [

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
        'Alert' => RealRashid\SweetAlert\Facades\Alert::class,


    ])->toArray(),

];
