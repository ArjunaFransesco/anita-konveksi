<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\GoogleReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\PenggajianController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;

// Beri nama 'home' pada route utama
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/testimoni', [GoogleReviewController::class, 'getReviews'])->name('testimoni');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'ownerDashboard'])->name('dashboard');
        Route::get('/transaksi', [OwnerController::class, 'transaksi'])->name('transaksi');
        Route::get('/laporan', [OwnerController::class, 'laporan'])->name('laporan');
        Route::get('/piutang', [OwnerController::class, 'piutang'])->name('piutang');
        Route::get('/monitoring-produksi', [OwnerController::class, 'monitoringProduksi'])->name('monitoring');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    });

    Route::middleware('role:kasir')->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'kasirDashboard'])->name('dashboard');

        // Input & daftar pesanan
        Route::get('/pesanan/input',         [KasirController::class, 'inputPesanan'])->name('pesanan.input');
        Route::post('/pesanan/store',        [KasirController::class, 'storePesanan'])->name('pesanan.store');
        Route::get('/pesanan',               [KasirController::class, 'daftarPesanan'])->name('pesanan.index');

        // Update status produksi
        Route::get('/status/update',                      [KasirController::class, 'updateStatus'])->name('status.update');
        Route::post('/pesanan/{id}/status',               [KasirController::class, 'updateStatusProduksi'])->name('pesanan.status');

        // Catat pembayaran
        Route::get('/pembayaran/catat',      [KasirController::class, 'catatPembayaran'])->name('pembayaran.catat');
        Route::post('/pembayaran/store',     [KasirController::class, 'storePembayaran'])->name('pembayaran.store');
        Route::get('/pembayaran/order/{id}', [KasirController::class, 'getOrderDetail'])->name('pembayaran.order');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('employees', EmployeeController::class);
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
});