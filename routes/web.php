<?php

use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/users', UsersController::class, ['names' => 'users']);
    Route::resource('/rules', RulesController::class, ['names' => 'rules']);
});

Route::get('/error', function () {
    abort(500);
});


Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

//require __DIR__ . '/auth.php';
