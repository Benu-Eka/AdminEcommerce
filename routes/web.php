<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;

// =======================
// A. PUBLIK
// =======================
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login.post');

    // Admin registration (guest only)
    Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');
});


// =======================
// B. AUTH
// =======================
// Route::middleware('guest')->group(function () {
//     Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
//     Route::post('login', [LoginController::class, 'login']);
// });

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
            
            // Route Toggle - Menggunakan POST agar sesuai dengan tag <form>
            Route::post('/toggle/{kode_barang}', [ProductController::class, 'toggleVisibility'])
                ->name('toggleVisibility');

        });

        // =======================
        // KELOLA PESANAN
        // =======================
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::post('/{orderId}/update-status', [OrderController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{orderId}/approve-cancel', [OrderController::class, 'approveCancel'])->name('approveCancel');
        });
    }); // Pastikan kurung ini menutup group prefix 'admin'