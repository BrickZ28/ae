<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
	public function register(): void
	{

	}

	public function boot(): void
	{
        View::composer('*', function ($view) {
   $cartIsEmpty = auth()->user() && auth()->user()->cart ? auth()->user()->cart->items->isEmpty() : true;
    $view->with('cartIsEmpty', $cartIsEmpty);
});
	}
}
