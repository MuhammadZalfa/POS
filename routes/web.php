<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('products', function () {
    return view('admin.produk');
})->name('admin.products');

Route::get('inventory', function () {
    return view('admin.inventori');
})->name('admin.inventory');

Route::get('laporan', function () {
    return view('admin.laporan');
})->name('admin.laporan');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');
