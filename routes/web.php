<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisIzinController;
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
    // My Profile
    Route::get('profile', [AuthenticationController::class, 'profile'])->name('profile.index');
    Route::put('profile', [AuthenticationController::class, 'updateProfile'])->name('profile.update');
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ADMINISTRATOR
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        // Master Data
        Route::prefix('master-data')->name('master-data.')->group(function () {
            // Jenis Izin
            Route::prefix('jenis-izin')->name('jenis-izin.')->group(function () {
                Route::get('/', [JenisIzinController::class, 'index'])->name('index');
                // Route::post('/', [JenisIzinController::class, 'store'])->name('store');
                // Route::get('/{id}', [JenisIzinController::class, 'show'])->name('show');
                // Route::put('/{id}', [JenisIzinController::class, 'update'])->name('update');
                // Route::delete('/{id}', [JenisIzinController::class, 'destroy'])->name('destroy');

                // Table
                Route::get('/table', [JenisIzinController::class, 'jenisIzinTable'])->name('table');
            });
        });
    });

    // VERIFIKATOR
    Route::middleware(['role:verifikator'])->group(function () {});

    // PUBLIC
    Route::middleware(['role:public', 'is_filled_data_register'])->group(function () {});


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
