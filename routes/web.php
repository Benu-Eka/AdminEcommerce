<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// =======================
// A. PUBLIK
// =======================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// =======================
// B. AUTH
// =======================
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::post('logout', [LoginController::class, 'logout'])
    ->name('admin.logout')
    ->middleware('auth');

// =======================
// C. ADMIN (WAJIB LOGIN)
// =======================
Route::prefix('admin')
    ->name('admin.') // Menambahkan prefix name agar semua route di bawah otomatis memiliki prefix 'admin.'
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Dashboard - Sekarang menggunakan DashboardController
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // =======================
        // CHAT ADMIN
        // =======================
        Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('/', [AdminChatController::class, 'index'])->name('index');
            Route::get('{pelangganId}', [AdminChatController::class, 'chat'])->name('view');
            Route::post('send', [AdminChatController::class, 'send'])->name('send');
            Route::get('fetch/{pelangganId}', [AdminChatController::class, 'fetch'])->name('fetch');
        });

        // =======================
        // MANAJEMEN PRODUK
        // =======================
        Route::prefix('manajemenProduk')->name('manajemenProduk.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            // Toggle Status Aktif/Tampil (is_visible)
            Route::post('toggle/{kodeBarang}', [ProductController::class, 'toggleVisibility'])->name('toggleVisibility');
        });

    }); // Pastikan kurung ini menutup group prefix 'admin'