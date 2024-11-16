<?php

use App\Http\Controllers\Admin\MasterController as AdminMasterController;
use App\Http\Controllers\User\MasterController as UserMasterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\VerifyUserController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect('/login');
});

// Guest Routes (untuk user yang belum login)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register Routes
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('/register/success', [RegisterController::class, 'success'])->name('register.success');

});

// Authenticated Routes (untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Mahasiswa Routes
    Route::middleware('role:mahasiswa')->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserMasterController::class, 'index'])->name('dashboard');

        // Absensi Routes
        Route::prefix('absens')->name('absens.')->group(function () {
            Route::get('/', [UserMasterController::class, 'index'])->name('index');
            Route::get('/create', [UserMasterController::class, 'create'])->name('create');
            Route::post('/', [UserMasterController::class, 'storeabsen'])->name('store');
        });

        // Laporan Routes
        Route::prefix('laporans')->name('laporans.')->group(function () {
            Route::get('/', [UserMasterController::class, 'indexlaporan'])->name('index');
            Route::get('/create', [UserMasterController::class, 'createlaporan'])->name('create');
            Route::post('/', [UserMasterController::class, 'storelaporan'])->name('store');
        });
    });

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminMasterController::class, 'index'])->name('dashboard');

        // Verifikasi User
        Route::get('/verify-users', [AdminMasterController::class, 'verifyUsersIndex'])->name('verify.users');
        Route::post('/verify-user/{user}', [VerifyUserController::class, 'verify'])->name('verify.user');
        Route::post('/verify-user/{id}/reject', [AdminMasterController::class, 'rejectUser'])->name('verify.user.reject');

        // Surat Balasan
        Route::get('/surat-balasans', [AdminMasterController::class, 'suratBalasansIndex'])->name('surat_balasans.index');
        Route::get('/surat-balasans/create/{userId}', [AdminMasterController::class, 'showSuratBalasanForm'])->name('surat_balasans.create');
        Route::post('/surat-balasans/store', [AdminMasterController::class, 'storeSuratBalasan'])->name('surat_balasans.store');

        // Verifikasi Absensi
        Route::get('/absens', [AdminMasterController::class, 'absensIndex'])->name('absens.index');
        Route::post('/absens/verify/{id}', [AdminMasterController::class, 'verifyAbsen'])->name('absens.verify');

        // Manajemen Kelas
        Route::prefix('kelas')->name('kelas.')->group(function () {
            Route::get('/', [AdminMasterController::class, 'viewKelas'])->name('index');
            Route::get('/create', [AdminMasterController::class, 'createKelas'])->name('create');
            Route::get('/edit/{id}', [AdminMasterController::class, 'editKelas'])->name('edit');
            Route::post('/store', [AdminMasterController::class, 'simpanKelas'])->name('store');
            Route::delete('/{id}', [AdminMasterController::class, 'deleteKelas'])->name('delete');
        });

        // Laporan Management
        Route::prefix('laporans')->name('laporans.')->group(function () {
            Route::get('/', [AdminMasterController::class, 'laporansIndex'])->name('index');
            Route::get('/{id}/surat-selesai', [AdminMasterController::class, 'createSuratSelesai'])->name('surat.create');
            Route::post('/{id}/surat-selesai', [AdminMasterController::class, 'storeSuratSelesai'])->name('surat.store');
        });

        // Surat Selesai
        Route::prefix('suratselesai')->name('suratselesai.')->group(function () {
            Route::get('/', [AdminMasterController::class, 'suratSelesaiIndex'])->name('index');
            Route::get('/create/{id}', [AdminMasterController::class, 'createSuratSelesai'])->name('create');
            Route::post('/store/{id}', [AdminMasterController::class, 'storeSuratSelesai'])->name('store');
        });
    });
});
