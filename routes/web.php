<?php

use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscordController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\ScreenshotController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ServerSettingsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


Route::get('/discord', [DiscordController::class, 'index']);
Route::get('/interactions', [DiscordController::class, 'fromDiscord']);
Route::post('/discord/receive-info', [DiscordController::class, 'receiveInfo']);
Route::get('/', [LandingController::class, 'index'])->name('landing.index');


Route::get('/discord/register', [SocialiteController::class, 'authenticate'])->name('discord.register');
Route::get('/discord/callback', [SocialiteController::class, 'redirect']);



//Route::name('user-management.')->group(function () {
//    Route::resource('/user-management/users', UserManagementController::class);
//    Route::resource('/user-management/roles', RoleManagementController::class);
//    Route::resource('/user-management/permissions', PermissionManagementController::class);
//});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::resource('/users', UsersController::class, ['names' => 'users']);
    Route::resource('/rules', RulesController::class, ['names' => 'rules']);
    Route::resource('/screenshots', ScreenshotController::class, ['names' => 'screenshots']);
    Route::resource('/servers', ServerController::class, ['names' => 'servers']);
});

Route::get('/error', function () {
    abort(500);
});


Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

//require __DIR__ . '/auth.php';
