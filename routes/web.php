<?php

use App\Http\Controllers\Admin\MasterController as AdminMasterController;
use App\Http\Controllers\User\MasterController as UserMasterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\VerifyUserController;
use App\Http\Controllers\SuperAdmin\DivisiController;
use App\Http\Controllers\SuperAdmin\AdminDivisiController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\AdminDivisi\AdminDivisiController as DivisiAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Redirect root ke dashboard sesuai role
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->roles->contains('name', 'super_admin')) {
            return redirect()->route('super_admin.dashboard');
        }
        if (Auth::user()->roles->contains('name', 'admin_divisi')) {
            return redirect()->route('admin_divisi.dashboard');
        }
        if (Auth::user()->roles->contains('name', 'mahasiswa')) {
            return redirect()->route('dashboard');
        }
    }
    return redirect()->route('login');
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

        // Surat Selesai
        Route::prefix('suratselesai')->name('suratselesai.')->group(function () {
            Route::get('/', [AdminMasterController::class, 'suratSelesaiIndex'])->name('index');
            Route::get('/create/{id}', [AdminMasterController::class, 'createSuratSelesai'])->name('create');
            Route::post('/store/{id}', [AdminMasterController::class, 'storeSuratSelesai'])->name('store');
        });
    });

    // Super Admin Routes
    Route::middleware('role:super_admin')->prefix('super-admin')->name('super_admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        
        // Verifikasi Mahasiswa
        Route::get('/verify-users', [SuperAdminController::class, 'verifyUsers'])->name('verify.users');
        Route::post('/verify-user/{id}', [SuperAdminController::class, 'verifyUser'])->name('verify.user');
        Route::post('/reject-user/{id}', [SuperAdminController::class, 'rejectUser'])->name('reject.user');
        
        // Route lainnya
        Route::resource('divisi', DivisiController::class);
        Route::resource('admin-divisi', AdminDivisiController::class);
        Route::post('/assign-divisi/{user}', [SuperAdminController::class, 'assignDivisi'])->name('assign.divisi');
    });

    // Admin Divisi Routes
    Route::middleware('role:admin_divisi')->prefix('admin-divisi')->name('admin_divisi.')->group(function () {
        Route::get('/dashboard', [DivisiAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/mahasiswa', [DivisiAdminController::class, 'mahasiswa'])->name('mahasiswa');
        Route::get('/absensi', [DivisiAdminController::class, 'absensi'])->name('absensi');
        Route::get('/laporan', [DivisiAdminController::class, 'laporan'])->name('laporan');
        
        // Verifikasi Routes
        Route::post('/absensi/{id}/verify', [DivisiAdminController::class, 'verifyAbsen'])->name('absensi.verify');
        Route::post('/laporan/{id}/verify', [DivisiAdminController::class, 'verifyLaporan'])->name('laporan.verify');
        Route::post('/laporan/{id}/reject', [DivisiAdminController::class, 'rejectLaporan'])->name('laporan.reject');
    });
});
