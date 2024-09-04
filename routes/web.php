<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisIzinController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserPermohonanController;

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
})->name('home');

Route::get('/panduan-pengguna', function () {
    return view('pages.landing.user-guide');
})->name('user-guide');;

Route::get('/cek-permohonan', function () {
    return view('pages.landing.check-application');
})->name('check-application');;

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

    // PUBLIC
    Route::middleware(['role:public'])->group(function () {
        Route::prefix('public')->name('public.')->group(function () {
            // Permohonan
            Route::prefix('permohonan')->name('permohonan.')->group(function () {
                // Table
                Route::get('/permohonan-table', [UserPermohonanController::class, 'permohonanTable'])->name('permohonan-table');
                Route::get('/jenis-izin-table', [UserPermohonanController::class, 'jenisIzinTable'])->name('jenis-izin-table');

                // Resource
                Route::get('/{permohonan}', [UserPermohonanController::class, 'show'])->name('show');
                Route::get('/create', [UserPermohonanController::class, 'create'])->name('create');
                Route::get('/create/{jenis_izin}', [UserPermohonanController::class, 'createPermohonan'])->name('create-permohonan');
                Route::post('/submit-form/{jenis_izin}', [UserPermohonanController::class, 'submitForm'])->name('submit-form');
                Route::post('/submit-berkas/{permohonan}', [UserPermohonanController::class, 'submitBerkas'])->name('submit-berkas');

                // Ajax
                Route::post('/store-berkas/{permohonan}', [UserPermohonanController::class, 'storeBerkas'])->name('store-berkas');
            });
        });
    });

    // ADMINISTRATOR
    Route::middleware(['role:administrator'])->group(function () {});
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        // Permohonan
        Route::prefix('permohonan')->name('permohonan.')->group(function () {
            // Table
            Route::get('/table', [PermohonanController::class, 'permohonanTable'])->name('table');

            // Resource
            Route::get('/', [PermohonanController::class, 'index'])->name('index');
            Route::get('/create', [PermohonanController::class, 'create'])->name('create');
            Route::post('/', [PermohonanController::class, 'store'])->name('store');
            Route::get('/{id}', [PermohonanController::class, 'show'])->name('show');
            Route::put('/{id}', [PermohonanController::class, 'update'])->name('update');
            Route::delete('/{id}', [PermohonanController::class, 'destroy'])->name('destroy');
        });

        // Master Data
        Route::prefix('master-data')->name('master-data.')->group(function () {
            // User
            Route::prefix('user')->name('user.')->group(function () {
                // Table
                Route::get('/table', [UserController::class, 'userTable'])->name('table');

                // Resource
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/', [UserController::class, 'store'])->name('store');
                Route::get('/{id}',  [UserController::class, 'show'])->name('show');
                Route::put('/{id}', [UserController::class, 'update'])->name('update');
            });

            // Jenis Izin
            Route::prefix('jenis-izin')->name('jenis-izin.')->group(function () {
                // Table
                Route::get('/table', [JenisIzinController::class, 'jenisIzinTable'])->name('table');

                // Ajax
                Route::get('/list-verifikator', [UserController::class, 'getListVerifikator'])->name('list-verifikator');

                // Resource
                Route::get('/', [JenisIzinController::class, 'index'])->name('index');
                Route::get('/create', [JenisIzinController::class, 'create'])->name('create');
                Route::post('/', [JenisIzinController::class, 'store'])->name('store');
                Route::get('/{id}', [JenisIzinController::class, 'show'])->name('show');
                Route::put('/{id}', [JenisIzinController::class, 'update'])->name('update');
                // Route::delete('/{id}', [JenisIzinController::class, 'destroy'])->name('destroy');

            });
        });
    });

    // VERIFIKATOR
    Route::middleware(['role:verifikator'])->group(function () {});


    // OPERATOR
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
