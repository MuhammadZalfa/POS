<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ResepProdukController;
use App\Http\Controllers\Kasir\KasirController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    Route::get('/produk', [ProdukController::class, 'index'])->name('products');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::patch('/produk/{produk}/toggle-status', [ProdukController::class, 'toggleStatus'])->name('produk.toggle');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/inventaris', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventaris/item', [InventoryController::class, 'storeItem'])->name('inventory.item.store');
    Route::put('/inventaris/item/{item}', [InventoryController::class, 'updateItem'])->name('inventory.item.update');
    Route::post('/inventaris/tambah-stok', [InventoryController::class, 'storeStock'])->name('inventory.stock.store');
    Route::post('/inventaris/set-stok', [InventoryController::class, 'setStock'])->name('inventory.stock.set');

    Route::get('/resep-produk', [ResepProdukController::class, 'index'])->name('recipes');
    Route::post('/resep-produk/{produk}', [ResepProdukController::class, 'update'])->name('recipes.update');

    Route::get('/laporan', fn () => view('admin.laporan'))->name('laporan');

    Route::get('/pilih-peran', fn () => view('auth.logoutAdmin'))->name('pilihPeran');
    Route::post('/logout-admin', function () {
        return redirect()->route('admin.pilihPeran');
    })->name('auth.logoutAdmin');
});

Route::middleware(['auth'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', fn () => view('kasir.dashboard'))->name('dashboard');
    Route::get('/', [KasirController::class, 'index'])->name('index');
    Route::post('/transaksi', [KasirController::class, 'store'])->name('transaksi.store');
});


Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('kasir.dashboard');
    }

    return redirect()->route('login');
});
