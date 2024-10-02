<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisIzinController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\Api\ReklameController;
use App\Http\Controllers\UserReklameController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserPermohonanController;
use App\Http\Controllers\VerifikatorPermohonanController;

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

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/panduan-pengguna', [LandingController::class, 'userGuideIndex'])->name('user-guide');;

Route::prefix('cek-permohonan')->name('cek-permohonan.')->group(function () {
    Route::get('/', [LandingController::class, 'cekPermohonanIndex'])->name('index');
    Route::post('/', [LandingController::class, 'cekPermohonanStore'])->name('store');
});

Route::middleware(['guest'])->group(function () {
    // login
    Route::prefix('login')->name('login.')->group(function () {
        Route::get('/', [AuthenticationController::class, 'login'])
            ->name('index');
        Route::post('/', [AuthenticationController::class, 'authenticate'])
            ->name('store');
    });

    // forgot password
    Route::prefix('forgot-password')->name('forgot-password.')->group(function () {
        Route::get('/', [AuthenticationController::class, 'forgotPassword'])
            ->name('index');
        Route::post('/', [AuthenticationController::class, 'sendResetLinkEmail'])
            ->name('store');
    });

    // reset password
    Route::prefix('reset-password')->name('password.')->group(function () {
        Route::get('/{token}', [AuthenticationController::class, 'resetPassword'])
            ->name('reset');
        Route::post('/{token}', [AuthenticationController::class, 'updatePasswordReset'])
            ->name('update');
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
});


// auth
Route::middleware(['auth'])->group(function () {
    // My Profile
    Route::get('profile', [AuthenticationController::class, 'profile'])->name('profile.index');
    Route::put('profile', [AuthenticationController::class, 'updateProfile'])->name('profile.update');
    Route::put('update-password', [AuthenticationController::class, 'updatePassword'])->name('update-password');

    Route::middleware(['is_filled_data_register'])->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // All Role
        Route::get('download-izin-terbit/{permohonan}', [PermohonanController::class, 'downloadIzinTerbit'])->name('download-izin-terbit');

        // PUBLIC
        Route::middleware(['role:public'])->group(function () {
            Route::prefix('public')->name('public.')->group(function () {
                // Permohonan
                Route::prefix('permohonan')->name('permohonan.')->group(function () {
                    // Table
                    Route::get('/permohonan-table', [UserPermohonanController::class, 'permohonanTable'])->name('permohonan-table');
                    Route::get('/jenis-izin-table', [UserPermohonanController::class, 'jenisIzinTable'])->name('jenis-izin-table');

                    // Resource
                    Route::get('/create', [UserPermohonanController::class, 'create'])->name('create');
                    Route::get('/{permohonan}', [UserPermohonanController::class, 'show'])->name('show');
                    Route::get('/create/{jenis_izin}', [UserPermohonanController::class, 'createPermohonan'])->name('create-permohonan');
                    Route::post('/submit-form/{jenis_izin}', [UserPermohonanController::class, 'submitForm'])->name('submit-form');
                    Route::post('/submit-berkas/{permohonan}', [UserPermohonanController::class, 'submitBerkas'])->name('submit-berkas');
                    Route::post('/revisi/{permohonan}', [UserPermohonanController::class, 'revisi'])->name('revisi');

                    // Ajax
                    Route::post('/store-berkas/{permohonan}', [UserPermohonanController::class, 'storeBerkas'])->name('store-berkas');
                });

                // Reklame
                Route::prefix('reklame')->name('reklame.')->group(function () {
                    Route::get('/', [UserReklameController::class, 'index'])->name('index');
                    Route::get('/create', [UserReklameController::class, 'create'])->name('create');
                    Route::get('/search', [UserReklameController::class, 'search'])->name('search');
                    Route::get('/registrasi', [UserReklameController::class, 'registrasi'])->name('registrasi');
                    Route::post('/registrasi', [UserReklameController::class, 'storeRegistrasi'])->name('store-registrasi');
                    Route::post('/{nomor_registrasi}', [UserReklameController::class, 'store'])->name('store');
                    Route::get('/create/{nomor_registrasi}', [UserReklameController::class, 'createReklame'])->name('create-reklame');
                    Route::post('/create/{nomor_registrasi}', [UserReklameController::class, 'storeReklame'])->name('store-reklame');
                    Route::delete('/delete/{nomor_registrasi}/{reklame}', [UserReklameController::class, 'destroyReklame'])->name('destroy-reklame');
                });

                // Kuesioner
                Route::prefix('kuesioner')->name('kuesioner.')->group(function () {
                    // Resource
                    Route::get('/create/{permohonan}', [KuesionerController::class, 'create'])->name('create');
                    Route::post('/store/{permohonan}', [KuesionerController::class, 'store'])->name('store');
                });
            });
        });

        // VERIFIKATOR
        Route::middleware(['role:verifikator'])->group(function () {
            Route::prefix('verifikator')->name('verifikator.')->group(function () {
                // Permohonan
                Route::prefix('permohonan')->name('permohonan.')->group(function () {
                    // Table
                    Route::get('/table', [VerifikatorPermohonanController::class, 'permohonanTable'])->name('table');

                    // Resource
                    Route::get('/', [VerifikatorPermohonanController::class, 'index'])->name('index');
                });

                // Verifikasi
                Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
                    // Table
                    Route::get('/verifikasi-table', [VerifikatorPermohonanController::class, 'verifikasiTable'])->name('table');

                    // Resource
                    Route::get('/', [VerifikatorPermohonanController::class, 'verifikasiIndex'])->name('index');
                    Route::get('/show/{permohonan}', [VerifikatorPermohonanController::class, 'show'])->name('show');
                    Route::post('/simpan-verifikasi/{permohonan}', [VerifikatorPermohonanController::class, 'simpanVerifikasi'])->name('verifikasi');

                    // Ajax
                    Route::post('/valid-berkas', [VerifikatorPermohonanController::class, 'validBerkas'])->name('valid-berkas');
                    Route::post('/revision-berkas', [VerifikatorPermohonanController::class, 'revisiBerkas'])->name('revisi-berkas');
                    Route::post('/upload-surat-permohonan-rekomendasi/{permohonan}', [VerifikatorPermohonanController::class, 'uploadSuratPermohonanRekomendasi'])->name('upload-surat-permohonan-rekomendasi');
                    Route::post('/upload-surat-rekomendasi/{permohonan}', [VerifikatorPermohonanController::class, 'uploadSuratRekomendasi'])->name('upload-surat-rekomendasi');
                    ROute::post('/generate-ulang-izin-terbit/{permohonan}', [VerifikatorPermohonanController::class, 'generateUlangIzinTerbit'])->name('generate-ulang-izin-terbit');
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
