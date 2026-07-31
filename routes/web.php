<?php

use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ROUTE LANDING PAGE
Route::get('/', [HomeController::class, 'index']);

// ROUTE BAWAAN BREEZE
require __DIR__.'/auth.php';

// ROUTE PANITIA
    Route::middleware(['auth', 'role:panitia'])->prefix('panitia')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PanitiaController::class, 'dashboard'])->name('panitia.dashboard');

    // Kelola pendaftar
    Route::get('/pendaftar', [PanitiaController::class, 'pendaftar'])->name('panitia.pendaftar');
    Route::get('/pendaftar/{id}', [PanitiaController::class, 'detail'])->name('panitia.detail');
    Route::post('/pendaftar/{id}/verifikasi', [PanitiaController::class, 'verifikasi'])->name('panitia.verifikasi');
    Route::post('/pendaftar/{id}/verifikasi-pembayaran', [PanitiaController::class, 'verifikasiPembayaran'])->name('panitia.verifikasi.pembayaran');

    // Kelola Jadwal
    Route::get('/jadwal', [PanitiaController::class, 'kelolaJadwal'])->name('panitia.kelola.jadwal');
    Route::get('/jadwal/{id}/create', [PanitiaController::class, 'createJadwal'])->name('panitia.jadwal.create');
    Route::post('/jadwal/{id}', [PanitiaController::class, 'simpanJadwal'])->name('panitia.jadwal.simpan');
    Route::delete('/jadwal/{id}/hapus', [PanitiaController::class, 'hapusJadwal'])->name('panitia.jadwal.hapus');
    Route::patch('/panitia/jadwal/{id}/selesai', [PanitiaController::class, 'tandaiSelesai'])->name('panitia.jadwal.selesai');

    // Kelola Hasil
    Route::get('/hasil', [PanitiaController::class, 'kelolaHasil'])->name('panitia.kelola.hasil');
    Route::get('/hasil/{id}/create', [PanitiaController::class, 'createHasil'])->name('panitia.hasil.create');
    Route::post('/hasil/{id}', [PanitiaController::class, 'simpanHasil'])->name('panitia.hasil.simpan');
    Route::delete('/hasil/{id}/hapus', [PanitiaController::class, 'hapusHasil'])->name('panitia.hasil.hapus');

     // Kelola Informasi (pengumuman & persyaratan)
    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
    Route::get('/informasi/create', [InformasiController::class, 'create'])->name('informasi.create');
    Route::post('/informasi', [InformasiController::class, 'store'])->name('informasi.store');
    Route::get('/informasi/{id}/edit', [InformasiController::class, 'edit'])->name('informasi.edit');
    Route::put('/informasi/{id}', [InformasiController::class, 'update'])->name('informasi.update');
    Route::delete('/informasi/{id}', [InformasiController::class, 'destroy'])->name('informasi.destroy');

    // Kelola Periode Pendaftaran
    Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
    Route::get('/periode/create', [PeriodeController::class, 'create'])->name('periode.create');
    Route::post('/periode', [PeriodeController::class, 'store'])->name('periode.store');
    Route::get('/periode/{id}/edit', [PeriodeController::class, 'edit'])->name('periode.edit');
    Route::put('/periode/{id}', [PeriodeController::class, 'update'])->name('periode.update');
    Route::delete('/periode/{id}', [PeriodeController::class, 'destroy'])->name('periode.destroy');
});

// ROUTE PIMPINAN
    Route::middleware(['auth', 'role:pimpinan'])->prefix('pimpinan')->group(function () {
    Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('pimpinan.dashboard');
    Route::get('/laporan', [PimpinanController::class, 'laporan'])->name('pimpinan.laporan');
    Route::get('/laporan/export', [PimpinanController::class, 'exportCsv'])->name('pimpinan.laporan.export');
    Route::get('/pimpinan/laporan/export-excel', [PimpinanController::class, 'exportExcel'])->name('pimpinan.laporan.export.excel');
});

// ROUTE CALON SANTRI
    Route::middleware(['auth', 'role:calon santri'])->prefix('santri')->group(function () {
    Route::get('/dashboard', [SantriController::class, 'dashboard'])->name('santri.dashboard');

    // Form multi-step
    Route::get('/daftar/step1', [PendaftaranController::class, 'step1'])->name('pendaftaran.step1');
    Route::post('/daftar/step1', [PendaftaranController::class, 'simpanStep1'])->name('pendaftaran.simpanStep1');

    Route::get('/daftar/step2', [PendaftaranController::class, 'step2'])->name('pendaftaran.step2');
    Route::post('/daftar/step2', [PendaftaranController::class, 'simpanStep2'])->name('pendaftaran.simpanStep2');

    Route::get('/daftar/step3', [PendaftaranController::class, 'step3'])->name('pendaftaran.step3');
    Route::post('/daftar/step3', [PendaftaranController::class, 'simpanStep3'])->name('pendaftaran.simpanStep3');

    // Preview & Submit
    Route::get('/daftar/preview', [PendaftaranController::class, 'preview'])->name('pendaftaran.preview');
    Route::post('/daftar/submit', [PendaftaranController::class, 'submit'])->name('pendaftaran.submit');
    Route::get('/daftar/detail', [PendaftaranController::class, 'detail'])->name('pendaftaran.detail');

    // Hapus draft
    Route::delete('/daftar/hapus', [PendaftaranController::class, 'hapusDraft'])->name('pendaftaran.hapus');

    // Status pendaftaran
    Route::get('/status', [PendaftaranController::class, 'status'])->name('pendaftaran.status');
});
