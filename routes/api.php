<?php

use App\Http\Controllers\Api\v1\ApiAuthController;
use App\Http\Controllers\Api\v1\RuleController;
use App\Http\Controllers\SpecialsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::resource('/rule', RuleController::class);

});
Route::get('/calendar/specials', [SpecialsController::class, 'showCalendar']);
Route::post('/login', [ApiAuthController::class, 'login']);
