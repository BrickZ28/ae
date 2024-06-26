<?php

use App\Http\Middleware\FetchDiscordUserMiddleware;
use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \SocialiteProviders\Manager\ServiceProvider::class,
        \RealRashid\SweetAlert\SweetAlertServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('discord.register'));
        $middleware->redirectUsersTo(AppServiceProvider::HOME);

        $middleware->web(\RealRashid\SweetAlert\ToSweetAlert::class);

        $middleware->throttleApi();

        $middleware->replaceInGroup('web', \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class, \App\Http\Middleware\VerifyCsrfToken::class);

        $middleware->alias([
            'discord.user' => FetchDiscordUserMiddleware::class
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
