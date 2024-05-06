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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DiscordService::class, function () {
            return new DiscordService();
        });

        $this->app->singleton(UserService::class, function () {
            // Inject DiscordService into UserService
            return new UserService(app(DiscordService::class));
        });

        $this->app->bind('App\\Services\\Stripe\\*', function ($parameters) {
            $class = $parameters['class'];
            return new $class(config('services.stripe.secret'));
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
