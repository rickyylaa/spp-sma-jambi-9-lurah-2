<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtamaController;
use App\Http\Controllers\Auth\RoleController;

use App\Http\Controllers\Admin\SppController as AdminSppController;
use App\Http\Controllers\Admin\WaliController as AdminWaliController;
use App\Http\Controllers\Admin\KelasController as AdminKelasController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\RekeningController as AdminRekeningController;
use App\Http\Controllers\Admin\OperatorController as AdminOperatorController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

use App\Http\Controllers\Operator\SiswaController as OperatorSiswaController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\PembayaranController as OperatorPembayaranController;
use App\Http\Controllers\Operator\NotificationController as OperatorNotificationController;

use App\Http\Controllers\Wali\PembayaranController as WaliPembayaranController;

/* ROUTE */

Auth::routes();
Route::get('/pembayaran/semua/{nisn}', [OperatorPembayaranController::class, 'getSemuaPembayaran'])->name('getSemuaPembayaran');
Route::get('/pembayaran/terakhir/{nisn}', [OperatorPembayaranController::class, 'getPembayaranTerakhir'])->name('getPembayaranTerakhir');
Route::get('/pembayaran/getSpp', [OperatorPembayaranController::class, 'getSpp'])->name('getSpp');

// Route::get('/', [UtamaController::class, 'index'])->name('utama.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/roles', RoleController::class);

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/admin/operator', [AdminOperatorController::class, 'index'])->name('admin.operator');
        Route::post('/admin/operator', [AdminOperatorController::class, 'store'])->name('admin.operatorStore');
        Route::put('/admin/operator/{username}', [AdminOperatorController::class, 'update'])->name('admin.operatorUpdate');
        Route::delete('/admin/operator/{username}', [AdminOperatorController::class, 'destroy'])->name('admin.operatorDestroy');

        Route::get('/admin/wali', [AdminWaliController::class, 'index'])->name('admin.wali');
        Route::post('/admin/wali', [AdminWaliController::class, 'store'])->name('admin.waliStore');
        Route::put('/admin/wali/{username}', [AdminWaliController::class, 'update'])->name('admin.waliUpdate');
        Route::delete('/admin/wali/{username}', [AdminWaliController::class, 'destroy'])->name('admin.waliDestroy');

        Route::get('/admin/kelas', [AdminKelasController::class, 'index'])->name('admin.kelas');
        Route::post('/admin/kelas', [AdminKelasController::class, 'store'])->name('admin.kelasStore');
        Route::put('/admin/kelas/{id}', [AdminKelasController::class, 'update'])->name('admin.kelasUpdate');
        Route::delete('/admin/kelas/{id}', [AdminKelasController::class, 'destroy'])->name('admin.kelasDestroy');

        Route::get('/admin/siswa', [AdminSiswaController::class, 'index'])->name('admin.siswa');
        Route::post('/admin/siswa', [AdminSiswaController::class, 'store'])->name('admin.siswaStore');
        Route::put('/admin/siswa/{nisn}', [AdminSiswaController::class, 'update'])->name('admin.siswaUpdate');
        Route::delete('/admin/siswa/{nisn}', [AdminSiswaController::class, 'destroy'])->name('admin.siswaDestroy');

        Route::get('/admin/spp', [AdminSppController::class, 'index'])->name('admin.spp');
        Route::post('/admin/spp', [AdminSppController::class, 'store'])->name('admin.sppStore');
        Route::put('/admin/spp/{id}', [AdminSppController::class, 'update'])->name('admin.sppUpdate');
        Route::delete('/admin/spp/{id}', [AdminSppController::class, 'destroy'])->name('admin.sppDestroy');

        Route::get('/admin/rekening', [AdminRekeningController::class, 'index'])->name('admin.rekening');
        Route::post('/admin/rekening', [AdminRekeningController::class, 'store'])->name('admin.rekeningStore');
        Route::put('/admin/rekening/{id}', [AdminRekeningController::class, 'update'])->name('admin.rekeningUpdate');
        Route::delete('/admin/rekening/{id}', [AdminRekeningController::class, 'destroy'])->name('admin.rekeningDestroy');

        Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan');
        Route::get('/admin/laporan/pdf/{daterange}', [AdminLaporanController::class, 'pdf'])->name('admin.laporanPDF');
    });

    Route::middleware(['role:operator'])->group(function () {
        Route::get('/operator/dashboard', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');

        Route::get('/operator/siswa', [OperatorSiswaController::class, 'index'])->name('operator.siswa');

        Route::get('/operator/pembayaran', [OperatorPembayaranController::class, 'index'])->name('operator.pembayaran');
        Route::post('/operator/pembayaran', [OperatorPembayaranController::class, 'store'])->name('operator.pembayaranStore');

        Route::get('/operator/pembayaran/pending', [OperatorPembayaranController::class, 'pending'])->name('operator.pembayaranPending');

        Route::get('/operator/pembayaran/terima', [OperatorPembayaranController::class, 'terima'])->name('operator.pembayaranTerima');
        Route::post('/operator/pembayaran/terima/{invoice}', [OperatorPembayaranController::class, 'terimaStore'])->name('operator.pembayaranTerimaStore');

        Route::get('/operator/pembayaran/tolak', [OperatorPembayaranController::class, 'tolak'])->name('operator.pembayaranTolak');
        Route::put('/operator/pembayaran/tolak/{invoice}', [OperatorPembayaranController::class, 'tolakStore'])->name('operator.pembayaranTolakStore');

        Route::post('/operator/markAsRead', [OperatorNotificationController::class, 'markAsRead'])->name('operator.markAsRead');
        Route::post('/operator/markAllAsRead', [OperatorNotificationController::class, 'markAllAsRead'])->name('operator.markAllAsRead');
    });

    Route::middleware(['role:wali'])->group(function () {
        Route::get('/wali/pembayaran', [WaliPembayaranController::class, 'index'])->name('wali.pembayaran');
        Route::post('/wali/pembayaran', [WaliPembayaranController::class, 'store'])->name('wali.pembayaranStore');

        Route::get('/wali/riwayat/pembayaran', [WaliPembayaranController::class, 'riwayat'])->name('wali.riwayat');
    });
});

/* ROUTE */
