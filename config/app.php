<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        \SocialiteProviders\Manager\ServiceProvider::class,
        RealRashid\SweetAlert\SweetAlertServiceProvider::class,
        Yajra\Datatables\DatatablesServiceProvider::class,

    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
        'Alert' => RealRashid\SweetAlert\Facades\Alert::class,
        'Datatables' => Yajra\Datatables\Facades\Datatables::class,

    ])->toArray(),

];
