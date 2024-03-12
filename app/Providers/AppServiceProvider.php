<?php

namespace App\Providers;

use App\Http\ViewComposers\UserViewComposer;
use App\Services\DiscordService;
use App\Services\UserService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DiscordService::class, function ($app) {
            return new DiscordService();
        });

        $this->app->singleton(UserService::class, function ($app) {
            // Inject DiscordService into UserService
            return new UserService($app->make(DiscordService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('checkRole', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyRole($expression)): ?>";
        });

        Blade::directive('endcheckRole', function ($role) {
            return '<?php endif; ?>';
        });

        View::composer('*', UserViewComposer::class);
    }
}
