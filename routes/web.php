<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaporanStokBarangController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

// Jika user belum login, arahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rute Autentikasi
Auth::routes();
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Middleware untuk memastikan user login sebelum mengakses halaman lain
Route::middleware(['auth'])->group(function () {
    // Route untuk Dashboard (Bisa diakses semua user yang login)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk fitur yang hanya bisa diakses oleh Owner, Admin Keuangan, dan Management
    Route::middleware(['auth', 'role:Owner,Admin Keuangan,Management'])->group(function () {
        Route::resource('pemasukan', PemasukanController::class);
        Route::resource('pengeluaran', PengeluaranController::class);
        Route::resource('hutang', HutangController::class);
        Route::put('/hutang/{id}/lunasi', [HutangController::class, 'lunasi'])->name('hutang.lunasi');

        // Route untuk Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pemasukan', [LaporanController::class, 'exportPemasukan'])->name('laporan.export-pemasukan');
        Route::get('/laporan/export-pengeluaran', [LaporanController::class, 'exportPengeluaran'])->name('laporan.export-pengeluaran');

        // Route untuk Export Pemasukan dan Pengeluaran
        Route::get('/export/pemasukan', [LaporanController::class, 'exportPemasukan'])->name('export.pemasukan');
        Route::get('/export/pemasukan/pdf', [LaporanController::class, 'exportPemasukanPDF'])->name('export.pemasukan.pdf');
        Route::get('/export/pengeluaran', [LaporanController::class, 'exportPengeluaran'])->name('export.pengeluaran');
        Route::get('/export/pengeluaran/pdf', [LaporanController::class, 'exportPengeluaranPDF'])->name('export.pengeluaran.pdf');

        // Route untuk Export PDF Laporan
        Route::get('/laporan/export-pemasukan-pdf', [LaporanController::class, 'exportPemasukanPDF'])->name('laporan.export-pemasukan-pdf');
        Route::get('/laporan/export-pengeluaran-pdf', [LaporanController::class, 'exportPengeluaranPDF'])->name('laporan.export-pengeluaran-pdf');
    });

    Route::middleware(['auth', 'role:Owner,Admin Stok Barang,Management'])->group(function () {
        Route::resource('stok_barang', StokBarangController::class);
        Route::get('/stok-barang/export', [StokBarangController::class, 'export'])->name('stok_barang.export');
    
        // Route untuk Stok Barang
        Route::resource('stok_barang', StokBarangController::class);
        Route::get('/stok-barang/export', [StokBarangController::class, 'export'])->name('stok_barang.export');
    
        // Rute untuk laporan stok barang
        Route::get('/laporan/stok', [LaporanStokBarangController::class, 'index'])->name('laporan.stok.index');
        Route::get('/laporan/stok/export-excel', [LaporanStokBarangController::class, 'exportExcel'])->name('laporan.stok.exportExcel');
        Route::get('/laporan/stok/export-pdf', [LaporanStokBarangController::class, 'exportPDF'])->name('laporan.stok.exportPDF');

        // Route untuk Export PDF Stok Barang
        Route::get('/export-stok-barang-pdf', [StokBarangController::class, 'exportStokBarangPDF']);
    });

    Route::middleware(['auth', 'role:Owner'])->group(function () {
    // Route resource untuk Admin (Hanya bisa diakses oleh user yang memiliki akses admin)
    Route::resource('admin', AdminController::class);

    // Route resource untuk Karyawan
    Route::resource('karyawan', KaryawanController::class);
    });
});
