<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\InventoryController;

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

    Route::get('/produk', [ProdukController::class, 'index'])->name('products');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');

    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::patch('/produk/{produk}/toggle-status', [ProdukController::class, 'toggleStatus'])->name('produk.toggle');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/inventaris', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventaris/tambah-stok', [InventoryController::class, 'storeStock'])->name('inventory.stock.store');
    Route::post('/inventaris/set-stok', [InventoryController::class, 'setStock'])->name('inventory.stock.set');

    Route::get('/laporan', fn() => view('admin.laporan'))->name('laporan');

    Route::get('/pilih-peran', fn() => view('auth.logoutAdmin'))->name('pilihPeran');

    Route::post('/logout-admin', function () {
        return redirect()->route('admin.pilihPeran');
    })->name('auth.logoutAdmin');
});

// Kasir routes
Route::middleware(['auth', 'kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', fn() => view('kasir.dashboard'))->name('dashboard');
});

// Halaman utama kasir
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