<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscordController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PlaystyleController;
use App\Http\Controllers\QuestionAttemptController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\ScreenshotsController;
use App\Http\Controllers\ServersController;
use App\Http\Controllers\SpecialsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UsersController;
use App\Models\QuestionAttempt;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/discord', [DiscordController::class, 'index']);
Route::get('/discord/register', [SocialiteController::class, 'authenticate'])->name('discord.register');
Route::get('/discord/callback', [SocialiteController::class, 'handleOAuthCallback']);
Route::post('/discord/receive-info', [DiscordController::class, 'receiveInfo']);
Route::get('/interactions', [DiscordController::class, 'fromDiscord']);
Route::get('/nitrado/servers', [ServersController::class, 'getServers']);
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

// Error Route
Route::get('/error', function () {
    abort(500);
});

// Private Routes (Authenticated and Verified Users)
Route::middleware(['auth', 'verified'])->group(function () {
    //Calendar
    Route::get('/calendars', [CalendarController::class, 'index'])->name('calendar.index');

    //Categories
    Route::resource('/categories', CategoryController::class, ['names' => 'categories']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //Item
    Route::resource('/items', ItemController::class, ['names' => 'items']);

    // User Profiles
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::resource('/users', UsersController::class, ['names' => 'users']);

    //Package
    Route::resource('/packages', PackageController::class, ['names' => 'packages']);

    //Playstyle
    Route::resource('/playstyles', PlaystyleController::class, ['names' => 'playstyles']);

    // Rules
    Route::resource('/rules', RulesController::class, ['names' => 'rules']);

    // Screenshots
    Route::resource('/screenshots', ScreenshotsController::class, ['names' => 'screenshots']);
    Route::patch('/screenshots/approve/{id}', [ScreenshotsController::class, 'approve'])->name('screenshots.approve');

    // Games
    Route::resource('/games', GamesController::class, ['names' => 'games']);

    // Servers
    Route::get('/dj/test/section', [ServersController::class, 'dj'])->name('servers.dj');
    Route::resource('/servers', ServersController::class, ['names' => 'servers']);

    // Specials
    Route::resource('/specials', SpecialsController::class, ['names' => 'specials']);

    // Logout
    Route::get('/logout', [SocialiteController::class, 'logout'])->name('logout');

    // Discord Role Sync
    Route::get('/discord/roles', [DiscordController::class, 'syncRolesAndRedirect'])->name('discord.user_info');

    //Profile
    Route::resource('/profiles', userProfileController::class, ['names' => 'profiles']);

    //Question
    Route::resource('/questions', QuestionController::class, ['names' => 'questions']);
    Route::get('/questions/user/random/{question_id?}', [QuestionController::class, 'randomUserQuestion'])->name('questions.user.random');

    Route::get('/questions/user/attempt/{id}', [QuestionAttemptController::class, 'attemptUserQuestion'])->name('questions.user.attempt');
});
