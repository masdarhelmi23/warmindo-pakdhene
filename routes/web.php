<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OwnerController;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - Warmindo Pakdhene (VERSI SINKRON DATABASE 'kasir')
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. HALAMAN PUBLIC / LANDING PAGE
// ==========================================
Route::get('/', function (Request $request) {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'owner') {
            return redirect('/owner/dashboard');
        }
        if ($user->role === 'kasir') {
            return redirect('/dashboard');
        }
    }

    $token = $request->query('t');
    $table = Table::where('token', $token)->first();
    return view('welcome', compact('table'));
})->name('welcome');


// ==========================================
// 2. AUTHENTICATION (Login/Logout)
// ==========================================
Route::middleware(['sudah_login'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::get('/force-logout', function(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login')->with('success', 'Session berhasil direset total!');
})->name('force.logout');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 3. PROTECTED ROUTES (Kunci Hak Akses Sistem)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // --- 🔒 GRUP AKSES: KHUSUS ROLE KASIR ---
    // SINKRONISASI: Menggunakan 'kasir' sesuai isi tabel users di database kamu
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/dashboard', [TableController::class, 'dashboard'])->name('dashboard');
        Route::get('/cashier', [TableController::class, 'cashier'])->name('cashier.index');
        Route::post('/cashier/approve', [TableController::class, 'approveOrder'])->name('cashier.approve');
        Route::get('/kitchen', [TableController::class, 'kitchen'])->name('kitchen.index');
        Route::post('/kitchen/done-group', [TableController::class, 'doneGroup'])->name('kitchen.done.group');
        Route::post('/kitchen/done/{order}', [TableController::class, 'done'])->name('kitchen.done');

        // Master Data Kasir
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
        Route::get('/tables', [TableController::class, 'index'])->name('tables.index');
        Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
        Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy');
    });

    // --- 🔒 GRUP AKSES: KHUSUS ROLE OWNER ---
    Route::middleware(['role:owner'])->group(function () {
        Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/owner/reports-detail', [TableController::class, 'reports'])->name('owner.reports');
    });
}); 


// ==========================================
// 4. CUSTOMER ORDER ROUTES (Akses Pelanggan)
// ==========================================
Route::prefix('order')->group(function () {
    Route::get('/menu', [TableController::class, 'customerOrder'])->name('order.menu');
    Route::post('/checkout', [TableController::class, 'processOrder'])->name('order.process');
    Route::get('/status/{order_id}', [TableController::class, 'orderStatus'])->name('order.status');
});