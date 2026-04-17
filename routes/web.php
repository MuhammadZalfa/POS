<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProdukController;


// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

// Logout default (untuk kasir & umum)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::get('/products', fn() => view('admin.produk'))->name('products');
    Route::get('/inventory', fn() => view('admin.inventori'))->name('inventory');
    Route::get('/laporan', fn() => view('admin.laporan'))->name('laporan');
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    
    // Halaman pilih peran (setelah admin "keluar" tapi tidak benar2 logout)
    Route::get('/pilih-peran', fn() => view('auth.logoutAdmin'))->name('pilihPeran');
    
    // Proses logout admin (tidak menghapus session, hanya redirect ke pilih peran)
    Route::post('/logout-admin', function () {
        // Jika ingin admin tetap login (session tetap ada) dan hanya pindah halaman:
        return redirect()->route('admin.pilihPeran');
        
        // Jika ingin admin benar2 logout, gunakan:
        // Auth::logout();
        // return redirect()->route('admin.pilihPeran');
    })->name('auth.logoutAdmin');
});

// Kasir routes (hanya untuk role kasir)
Route::middleware(['auth', 'kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', fn() => view('kasir.dashboard'))->name('dashboard');
    // Route lain untuk kasir (jika ada)
});

// Halaman utama kasir (transaksi) - bisa diakses oleh admin maupun kasir
Route::middleware('auth')->get('/kasir', function () {
    return view('kasir.kasir');
})->name('kasir');

// Root
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('kasir.dashboard');
    }
    return redirect()->route('login');
});