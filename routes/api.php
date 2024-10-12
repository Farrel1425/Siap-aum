<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReklameController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\OpenApi\AuthenticationController as OpenApiAuthenticationController;
use App\Http\Controllers\OpenApi\StatistikController;

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

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthenticationController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'role:inputer'])->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // Reklame
    Route::get('/reklame', [ReklameController::class, 'index']);
    Route::get('/reklame/{id}', [ReklameController::class, 'show']);
    Route::post('/reklame', [ReklameController::class, 'initReklame']);
    Route::post('/reklame/{id}', [ReklameController::class, 'storeReklame']);
});

// OPEN API
Route::prefix('v1')->group(function () {
    Route::post('/login', [OpenApiAuthenticationController::class, 'login']);
    Route::middleware(['auth:sanctum'])->group(function () {
        // Auth
        Route::post('/logout', [OpenApiAuthenticationController::class, 'logout']);

        // Statistik
        Route::get('/statistik-permohonan', [StatistikController::class, 'index']);
    });
});
