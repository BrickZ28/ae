<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [


    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
        'Alert' => RealRashid\SweetAlert\Facades\Alert::class,
        'Datatables' => Yajra\Datatables\Facades\Datatables::class,

    ])->toArray(),

];
