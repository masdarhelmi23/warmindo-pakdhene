<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. PUBLIC LANDING PAGE
Route::get('/', function (Request $request) {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'owner') return redirect('/owner/dashboard');
        if ($user->role === 'kasir') return redirect('/dashboard');
    }
    $token = $request->query('t');
    $table = Table::where('token', $token)->first();
    return view('welcome', compact('table'));
})->name('welcome');

// 2. AUTHENTICATION
Route::middleware(['sudah_login'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. PROTECTED ROUTES (ROLE BASED ACCESS)
Route::middleware(['auth'])->group(function () {

    // Rute yang bisa diakses KASIR & OWNER
    Route::middleware(['role:kasir,owner'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });

    // Rute KHUSUS KASIR
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/dashboard', [TableController::class, 'dashboard'])->name('dashboard');
        Route::get('/cashier', [TableController::class, 'cashier'])->name('cashier.index');
        Route::post('/cashier/approve', [TableController::class, 'approveOrder'])->name('cashier.approve');
        Route::get('/kitchen', [TableController::class, 'kitchen'])->name('kitchen.index');
        Route::post('/kitchen/done-group', [TableController::class, 'doneGroup'])->name('kitchen.done.group');
        Route::post('/kitchen/done/{order}', [TableController::class, 'done'])->name('kitchen.done');
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
        Route::get('/tables', [TableController::class, 'index'])->name('tables.index');
        Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
        Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy');
    });

    // Rute KHUSUS OWNER
    Route::middleware(['role:owner'])->group(function () {
        Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
        Route::get('/owner/reports-detail', [TableController::class, 'reports'])->name('owner.reports');
        
        // CRUD USER: Full Akses
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // Tambahan Rute
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

// 4. CUSTOMER ORDER
Route::prefix('order')->group(function () {
    Route::get('/menu', [TableController::class, 'customerOrder'])->name('order.menu');
    Route::post('/checkout', [TableController::class, 'processOrder'])->name('order.process');
    Route::get('/status/{order_id}', [TableController::class, 'orderStatus'])->name('order.status');
});