<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

// Halaman depan (bisa untuk scan QR nanti)
Route::get('/', function () { return view('welcome'); });

// Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Harus Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD Produk
    Route::resource('products', ProductController::class);
});

Route::middleware(['auth'])->group(function () {
    // ... route yang lain ...
    Route::get('/tables', [TableController::class, 'index'])->name('tables.index');
    Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Pastikan tulisannya 'admin.dashboard'
    })->name('dashboard');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/tables', [TableController::class, 'index'])->name('tables.index');
    Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
    Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Halaman Menu untuk Pelanggan (Scan dari QR)
Route::get('/order/table/{number}', [TableController::class, 'orderPage'])->name('order.table');
// Proses Checkout dari sisi Pelanggan
Route::post('/order/checkout', [TableController::class, 'processOrder'])->name('order.process');

Route::middleware(['auth'])->group(function () {
    // ... rute lainnya ...
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Halaman depan pelanggan (Menu Digital)
Route::get('/order/meja/{number}', [App\Http\Controllers\TableController::class, 'customerOrder'])->name('order.customer');

// Proses kirim pesanan dari pelanggan
Route::post('/order/checkout', [App\Http\Controllers\DashboardController::class, 'processOrder'])->name('order.process');