<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.landing.index');
});

Route::middleware(['guest'])->group(function () {
    // login
    Route::prefix('login')->name('login.')->group(function () {
        Route::get('/', [AuthenticationController::class, 'login'])
            ->name('index');
        Route::post('/', [AuthenticationController::class, 'authenticate'])
            ->name('store');
    });

    // register
    Route::prefix('register')->name('register.')->group(function () {
        Route::get('/', [AuthenticationController::class, 'register'])
            ->name('index');
        Route::post('/', [AuthenticationController::class, 'store'])
            ->name('store');

        // otp
        Route::prefix('otp')->name('otp.')->group(function () {
            Route::post('/generate', [AuthenticationController::class, 'generateOtp'])
                ->name('generate');
        });
    });

    // reset password
    // Route::name('password.')->group(function () {
    //     Route::get('/forgot-password', [ResetPasswordController::class, 'index'])->name('request');
    //     Route::post('/forgot-password', [ResetPasswordController::class, 'request'])->name('email');
    //     Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset');
    //     Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('update');
    // });
});


// auth
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ADMINISTRATOR
    Route::middleware(['role:administrator'])->group(function () {

    });

    // VERIFIKATOR
    Route::middleware(['role:verifikator'])->group(function () {
    });

    // OPERATOR
    Route::middleware(['role:public', 'is_filled_data_register'])->group(function () {
    });


    // Profile
    // Route::prefix('profile')->name('profile.')->group(function () {
    //     Route::get('/', [ProfileController::class, 'index'])
    //         ->name('index');
    //     Route::post('/', [ProfileController::class, 'store'])
    //         ->name('store');
    // });

    // Logout
    Route::post('logout', [AuthenticationController::class, 'logout'])
        ->name('logout');
});
