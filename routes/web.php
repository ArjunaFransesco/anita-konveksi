<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\GoogleReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmployeeController;

// Beri nama 'home' pada route utama
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/testimoni', [GoogleReviewController::class, 'getReviews'])->name('testimoni');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::middleware('role:owner')->group(function () {
        Route::get('/dashboard/owner', [DashboardController::class, 'ownerDashboard'])->name('dashboard.owner');
        Route::get('/owner/transaksi', [DashboardController::class, 'ownerDashboard'])->name('owner.transaksi');
        Route::get('/owner/laporan-pemasukan', [DashboardController::class, 'ownerDashboard'])->name('owner.laporan-pemasukan');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    });

    Route::middleware('role:kasir')->group(function () {
        Route::get('/dashboard/kasir', [DashboardController::class, 'kasirDashboard'])->name('dashboard.kasir');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('employees', EmployeeController::class);
});