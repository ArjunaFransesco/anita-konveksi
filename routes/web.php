<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\KatalogController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route domain publik
|--------------------------------------------------------------------------
*/
$registerPublicRoutes = static function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
    Route::get('/testimoni', [GoogleReviewController::class, 'getReviews'])->name('testimoni');
};

/*
|--------------------------------------------------------------------------
| Route domain staf
|--------------------------------------------------------------------------
*/
$registerStaffRoutes = static function (bool $includeEntryRoute = true): void {
    if ($includeEntryRoute) {
        Route::get('/', [LoginController::class, 'entry'])->name('staff.entry');
    }

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.attempt');
    Route::post('/logout', [LoginController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    Route::middleware('auth')->group(function (): void {
        Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function (): void {
            Route::get('/dashboard', [DashboardController::class, 'ownerDashboard'])->name('dashboard');
            Route::get('/transaksi', [OwnerController::class, 'transaksi'])->name('transaksi');
            Route::get('/transaksi/export/excel', [OwnerController::class, 'exportTransaksiExcel'])->name('transaksi.export.excel');
            Route::get('/transaksi/export/pdf', [OwnerController::class, 'exportTransaksiPdf'])->name('transaksi.export.pdf');
            Route::get('/laporan', [OwnerController::class, 'laporan'])->name('laporan');
            Route::get('/laporan/export/excel', [OwnerController::class, 'exportLaporanExcel'])->name('laporan.export.excel');
            Route::get('/laporan/export/pdf', [OwnerController::class, 'exportLaporanPdf'])->name('laporan.export.pdf');
            Route::get('/piutang', [OwnerController::class, 'piutang'])->name('piutang');
            Route::get('/monitoring-produksi', [OwnerController::class, 'monitoringProduksi'])->name('monitoring');

            // Fitur Kasir (menyatu ke Owner)
            Route::get('/pesanan/{id}/detail', [KasirController::class, 'detailPesanan'])->name('pesanan.detail');
            Route::get('/file-preview', [KasirController::class, 'previewFile'])->name('file.preview');
            Route::get('/pesanan/input', [KasirController::class, 'inputPesanan'])->name('pesanan.input');
            Route::post('/pesanan/store', [KasirController::class, 'storePesanan'])->name('pesanan.store');
            Route::get('/pesanan', [KasirController::class, 'daftarPesanan'])->name('pesanan.index');
            Route::get('/status/update', [KasirController::class, 'updateStatus'])->name('status.update');
            Route::post('/pesanan/{id}/status', [KasirController::class, 'updateStatusProduksi'])->name('pesanan.status');
            Route::get('/pembayaran/catat', [KasirController::class, 'catatPembayaran'])->name('pembayaran.catat');
            Route::post('/pembayaran/store', [KasirController::class, 'storePembayaran'])->name('pembayaran.store');
            Route::get('/pembayaran/order/{id}', [KasirController::class, 'getOrderDetail'])->name('pembayaran.order');

            // Modul Pengeluaran
            Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
            Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
            Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');
            Route::get('/pengeluaran/export/excel', [PengeluaranController::class, 'exportExcel'])->name('pengeluaran.export.excel');
            Route::get('/pengeluaran/export/pdf', [PengeluaranController::class, 'exportPdf'])->name('pengeluaran.export.pdf');

            // Kwitansi & Surat Pegawai
            Route::get('/pesanan/{id}/kwitansi', [KasirController::class, 'cetakKwitansi'])->name('pesanan.kwitansi');
            Route::get('/pesanan/{id}/surat-pegawai', [KasirController::class, 'suratPesananPegawai'])->name('pesanan.surat_pegawai');

            // Foto Hasil Produksi
            Route::post('/pesanan/{id}/hasil-foto', [KasirController::class, 'storeHasilFoto'])->name('pesanan.hasil_foto.store');
            Route::delete('/hasil-foto/{id}', [KasirController::class, 'destroyHasilFoto'])->name('pesanan.hasil_foto.destroy');
        });

        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function (): void {
            Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
            Route::resource('users', UserController::class);
            Route::resource('employees', EmployeeController::class);
            Route::resource('katalog', KatalogController::class);
            Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
            Route::post('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.status');
        });
    });
};

if (config('domains.enabled')) {
    $publicDomain = config('domains.public');
    $staffDomain = config('domains.staff');

    if (! is_string($publicDomain) || $publicDomain === '' || ! is_string($staffDomain) || $staffDomain === '') {
        throw new RuntimeException(
            'DOMAIN_ROUTING_ENABLED=true, tetapi PUBLIC_DOMAIN atau STAFF_DOMAIN belum diisi.'
        );
    }

    Route::domain($publicDomain)->group($registerPublicRoutes);
    Route::domain($staffDomain)->group(static function () use ($registerStaffRoutes): void {
        $registerStaffRoutes(true);
    });
} else {
    // Mode lokal: landing page di / dan login staf di /login pada host yang sama.
    $registerPublicRoutes();
    $registerStaffRoutes(false);
}
