<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscordController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlaystyleController;
use App\Http\Controllers\QuestionAttemptController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\ScreenshotsController;
use App\Http\Controllers\ServersController;
use App\Http\Controllers\SpecialsController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


// Public Routes
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/discord', [DiscordController::class, 'index']);
Route::get('/discord/register', [SocialiteController::class, 'authenticate'])->name('discord.register');
Route::get('/discord/callback', [SocialiteController::class, 'processUserAuthRequest'])->middleware('discord.user');
Route::get('/dashboard/registration/play-options', [DashboardController::class, 'playOptions'])->name('dashboard.play-options');
Route::get('/register/process', [SocialiteController::class, 'processUserRegistration'])->name('register.process');
Route::post('/discord/receive-info', [DiscordController::class, 'receiveInfo']);
Route::get('/interactions', [DiscordController::class, 'fromDiscord']);
Route::get('/nitrado/servers', [ServersController::class, 'getServers']);
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);
Route::get('/under-construction', function () {
    return view('under-construction');
});


// Error Route
Route::get('/error', function () {
    abort(500);
});

// Private Routes (Authenticated and Verified Users)
Route::middleware(['auth', 'verified'])->group(function () {
    //Calendar
    Route::get('/calendars', [CalendarController::class, 'index'])->name('calendar.index');

    //Cart
    Route::resource('/carts', CartController::class, ['names' => 'carts']);
    Route::patch('/carts/updateQuantity/{id}', [CartController::class, 'updateQuantity'])->name('carts.updateQuantity');
    Route::post('process-payment', [PaymentController::class, 'processPayment'])->name('process-payment');
    Route::get('/cancel-checkout', [PaymentController::class, 'cancelCheckout'])->name('cancel-checkout');

    //Categories
    Route::resource('/categories', CategoryController::class, ['names' => 'categories']);

    //Checkout
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Discord Role Sync
    Route::get('/discord/roles', [DiscordController::class, 'syncRolesAndRedirect'])->name('discord.user_info');

    // Games
    Route::resource('/games', GamesController::class, ['names' => 'games']);

    //Gates
    Route::resource('/gates', GateController::class, ['names' => 'gates']);
    Route::get('/gates/create/{game}/{style}', [GateController::class, 'getGates'])->name('gates.search');

    //Item
    Route::resource('/items', ItemController::class, ['names' => 'items']);

    // Logout
    Route::get('/logout', [SocialiteController::class, 'logout'])->name('logout');

    //menu
    Route::get('/items/{game}/{playstyle}/{category}', [ItemController::class, 'indexByGamePlaystyleCategory'])
        ->name('items.index.gpc');

    //orders
    Route::resource('/orders', OrderController::class, ['names' => 'orders']);
    Route::post('/orders/cancel/aec/items/{id}', [OrderController::class, 'cancelAECOrder'])->name('orders.cancel.aec');
    Route::get('/orders/inquiry/{id}', [OrderController::class, 'orderInquiry'])->name('orders.inquiry');

    //Package
    Route::resource('/packages', PackageController::class, ['names' => 'packages']);

    //Playstyle
    Route::resource('/playstyles', PlaystyleController::class, ['names' => 'playstyles']);

    //Profile
    Route::resource('/profiles', UserProfileController::class, ['names' => 'profiles']);

    //Question
    Route::resource('/questions', QuestionController::class, ['names' => 'questions']);
    Route::get('/questions/user/random/{question_id?}', [QuestionController::class, 'randomUserQuestion'])->name('questions.user.random');
    Route::get('/questions/user/attempt/{id}', [QuestionAttemptController::class, 'attemptUserQuestion'])->name('questions.user.attempt');

    // Rules
    Route::resource('/rules', RulesController::class, ['names' => 'rules']);

    // Screenshots
    Route::resource('/screenshots', ScreenshotsController::class, ['names' => 'screenshots']);
    Route::patch('/screenshots/approve/{id}', [ScreenshotsController::class, 'approve'])->name('screenshots.approve');

    // Servers
    Route::get('/dj/test/section', [ServersController::class, 'dj'])->name('servers.dj');
    Route::resource('/servers', ServersController::class, ['names' => 'servers']);

    // Specials
    Route::resource('/specials', SpecialsController::class, ['names' => 'specials']);

    //Status
    Route::resource('/statuses', StatusController::class, ['names' => 'statuses']);

    //Stripe
    Route::get('/stripe/product/sync', [ItemController::class, 'uploadToStripe'])->name('sync-product');
    //Transactions
    Route::resource('/transactions', TransactionsController::class, ['names' => 'transactions']);
    Route::get('stripe/success', [PaymentController::class, 'handleStripeSuccessResponse'])->name('payment.success');
    Route::get('stripe/cancel', [PaymentController::class, 'handleStripeCanxResponse'])->name('payment.cancel');

    // User
    Route::resource('/users', UsersController::class, ['names' => 'users']);
    Route::get('/transactions/history/{id}', [UsersController::class, 'transactionHistory'])->name('user.transactions');

});
